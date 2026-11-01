<?php

namespace App\Http\Controllers;

use App\Models\AturanGejala;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\SinonimGejala;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class KnowledgeBaseController extends Controller
{
    private const RESOURCES = ['penyakits', 'gejalas', 'rules', 'synonyms'];

    public function index(Request $request, string $resource)
    {
        $this->ensureResource($resource);

        $rows = match ($resource) {
            'penyakits' => Penyakit::query()->orderBy('kode')->get(),
            'gejalas' => Gejala::query()->orderBy('kode')->get(),
            'rules' => AturanGejala::with(['penyakit:id,kode,nama', 'gejala:id,kode,nama'])
                ->orderBy('penyakit_id')->get()
                ->map(fn (AturanGejala $rule) => [
                    'id' => $rule->id,
                    'penyakit_id' => $rule->penyakit_id,
                    'gejala_id' => $rule->gejala_id,
                    'cf_pakar' => (float) $rule->cf_pakar,
                    'penyakit' => $rule->penyakit,
                    'gejala' => $rule->gejala,
                ]),
            default => SinonimGejala::with('gejala:id,kode,nama')->orderBy('kata_tidak_baku')->get(),
        };

        return Inertia::render('dashboard/knowledge', [
            'resource' => $resource,
            'rows' => $rows,
            'penyakits' => Penyakit::query()->select('id', 'kode', 'nama')->orderBy('kode')->get(),
            'gejalas' => Gejala::query()->select('id', 'kode', 'nama')->orderBy('kode')->get(),
            'canManage' => $request->user()->role === 'pakar' || $resource === 'synonyms',
        ]);
    }

    public function store(Request $request, string $resource): RedirectResponse
    {
        $this->authorizeMutation($request, $resource);
        $data = $this->validatedData($request, $resource);

        match ($resource) {
            'penyakits' => Penyakit::create($data),
            'gejalas' => Gejala::create($data),
            'rules' => AturanGejala::create($data),
            'synonyms' => SinonimGejala::create($data),
        };

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function storeSynonymGroup(Request $request): RedirectResponse
    {
        $this->authorizeMutation($request, 'synonyms');
        $data = $this->validateSynonymGroup($request);
        $this->ensureSynonymsAreAvailable($data['kata_tidak_baku']);

        DB::transaction(function () use ($data) {
            foreach ($data['kata_tidak_baku'] as $alias) {
                SinonimGejala::create([
                    'gejala_id' => $data['gejala_id'] ?: null,
                    'kata_baku' => $data['kata_baku'],
                    'kata_tidak_baku' => trim($alias),
                ]);
            }
        });

        return back()->with('success', 'Kelompok sinonim berhasil ditambahkan.');
    }

    public function updateSynonymGroup(Request $request): RedirectResponse
    {
        $this->authorizeMutation($request, 'synonyms');
        $data = $this->validateSynonymGroup($request);
        $original = $request->validate([
            'original_gejala_id' => ['nullable', 'integer', 'exists:gejalas,id'],
            'original_kata_baku' => ['required', 'string', 'max:255'],
        ]);
        $originalGejalaId = $original['original_gejala_id'] ?: null;
        $groupQuery = $this->synonymGroupQuery($originalGejalaId, $original['original_kata_baku']);
        abort_unless($groupQuery->exists(), 404);
        $this->ensureSynonymsAreAvailable($data['kata_tidak_baku'], $originalGejalaId, $original['original_kata_baku']);

        DB::transaction(function () use ($data, $originalGejalaId, $original) {
            $this->synonymGroupQuery($originalGejalaId, $original['original_kata_baku'])->delete();

            foreach ($data['kata_tidak_baku'] as $alias) {
                SinonimGejala::create([
                    'gejala_id' => $data['gejala_id'] ?: null,
                    'kata_baku' => $data['kata_baku'],
                    'kata_tidak_baku' => trim($alias),
                ]);
            }
        });

        return back()->with('success', 'Kelompok sinonim berhasil diperbarui.');
    }

    public function destroySynonymGroup(Request $request): RedirectResponse
    {
        $this->authorizeMutation($request, 'synonyms');
        $data = $request->validate([
            'gejala_id' => ['nullable', 'integer', 'exists:gejalas,id'],
            'kata_baku' => ['required', 'string', 'max:255'],
        ]);

        $deleted = $this->synonymGroupQuery($data['gejala_id'] ?: null, $data['kata_baku'])->delete();
        abort_if($deleted === 0, 404);

        return back()->with('success', 'Kelompok sinonim berhasil dihapus.');
    }

    public function update(Request $request, string $resource, int $id): RedirectResponse
    {
        $this->authorizeMutation($request, $resource);
        $data = $this->validatedData($request, $resource, $id);
        $model = $this->findModel($resource, $id);
        $model->update($data);

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Request $request, string $resource, int $id): RedirectResponse
    {
        $this->authorizeMutation($request, $resource);
        $this->findModel($resource, $id)->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }

    private function ensureResource(string $resource): void
    {
        abort_unless(in_array($resource, self::RESOURCES, true), 404);
    }

    private function validateSynonymGroup(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'gejala_id' => ['nullable', 'integer', 'exists:gejalas,id'],
            'kata_baku' => ['required', 'string', 'max:255'],
            'kata_tidak_baku' => ['required', 'array', 'min:1'],
            'kata_tidak_baku.*' => ['required', 'string', 'max:255', 'distinct:ignore_case'],
        ]);

        return $validator->validate();
    }

    private function ensureSynonymsAreAvailable(
        array $aliases,
        ?int $originalGejalaId = null,
        ?string $originalKataBaku = null
    ): void {
        $errors = [];
        foreach ($aliases as $index => $alias) {
            $existing = SinonimGejala::where('kata_tidak_baku', trim($alias))->first();
            $belongsToOriginalGroup = $existing
                && $originalKataBaku !== null
                && $existing->kata_baku === $originalKataBaku
                && $existing->gejala_id == $originalGejalaId;

            if ($existing && ! $belongsToOriginalGroup) {
                $errors["kata_tidak_baku.{$index}"] = 'Kata tidak baku tersebut sudah digunakan.';
            }
        }

        if ($errors !== []) {
            throw \Illuminate\Validation\ValidationException::withMessages($errors);
        }
    }

    private function synonymGroupQuery(?int $gejalaId, string $kataBaku)
    {
        return SinonimGejala::query()
            ->where('kata_baku', $kataBaku)
            ->when(
                $gejalaId === null,
                fn ($query) => $query->whereNull('gejala_id'),
                fn ($query) => $query->where('gejala_id', $gejalaId)
            );
    }

    private function authorizeMutation(Request $request, string $resource): void
    {
        $this->ensureResource($resource);
        abort_unless(
            $request->user()->role === 'pakar'
                || ($request->user()->role === 'admin' && $resource === 'synonyms'),
            403
        );
    }

    private function validatedData(Request $request, string $resource, ?int $id = null): array
    {
        $this->ensureResource($resource);
        $unique = fn (string $table, string $column) => 'unique:'.$table.','.$column.($id ? ','.$id : '');
        $rules = match ($resource) {
            'penyakits' => [
                'kode' => ['required', 'string', 'max:20', $unique('penyakits', 'kode')],
                'nama' => ['required', 'string', 'max:255'],
                'deskripsi' => ['required', 'string'],
                'penyebab' => ['required', 'string'],
                'rekomendasi' => ['required', 'string'],
            ],
            'gejalas' => [
                'kode' => ['required', 'string', 'max:20', $unique('gejalas', 'kode')],
                'nama' => ['required', 'string', 'max:255'],
            ],
            'rules' => [
                'penyakit_id' => ['required', 'exists:penyakits,id'],
                'gejala_id' => ['required', 'exists:gejalas,id'],
                'cf_pakar' => ['required', 'numeric', 'between:0,1'],
            ],
            default => [
                'kata_tidak_baku' => ['required', 'string', 'max:255', $unique('sinonim_gejalas', 'kata_tidak_baku')],
                'kata_baku' => ['required', 'string', 'max:255'],
                'gejala_id' => ['nullable', 'exists:gejalas,id'],
            ],
        };

        $validator = Validator::make($request->all(), $rules);
        if ($resource === 'rules') {
            $validator->after(function ($validator) use ($request, $id) {
                $query = AturanGejala::where('penyakit_id', $request->input('penyakit_id'))
                    ->where('gejala_id', $request->input('gejala_id'));
                if ($id) {
                    $query->whereKeyNot($id);
                }
                if ($query->exists()) {
                    $validator->errors()->add('gejala_id', 'Kombinasi penyakit dan gejala tersebut sudah tersedia.');
                }
            });
        }

        return $validator->validate();
    }

    private function findModel(string $resource, int $id): Penyakit|Gejala|AturanGejala|SinonimGejala
    {
        $this->ensureResource($resource);

        return match ($resource) {
            'penyakits' => Penyakit::findOrFail($id),
            'gejalas' => Gejala::findOrFail($id),
            'rules' => AturanGejala::findOrFail($id),
            'synonyms' => SinonimGejala::findOrFail($id),
        };
    }
}