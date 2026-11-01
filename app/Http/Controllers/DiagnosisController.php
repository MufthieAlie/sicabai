<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\RiwayatDiagnosis;
use App\Models\SinonimGejala;
use App\Services\CertaintyFactorService;
use App\Services\FuzzyService;
use App\Services\GeminiService;
use App\Services\SymptomMatcherService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class DiagnosisController extends Controller
{
    public function index()
    {
        return Inertia::render('Diagnosis/Index');
    }

    public function ekstrak(
        Request $request,
        GeminiService $gemini,
        FuzzyService $fuzzy,
        SymptomMatcherService $matcher
    ) {
        $request->validate(['teks' => 'required|string|min:3']);

        $teksNormal = $fuzzy->normalize($request->teks);
        $daftarGejala = Gejala::select('kode', 'nama')->get()->toArray();
        $fallbackLokal = false;

        try {
            $hasil = $gemini->ekstrakGejala($teksNormal, $daftarGejala);
        } catch (\RuntimeException|ConnectionException $e) {
            Log::warning('Gemini unavailable; using local symptom matching', [
                'reason' => $e->getMessage(),
            ]);
            $sinonim = SinonimGejala::query()
                ->whereNotNull('gejala_id')
                ->with('gejala:id,kode')
                ->get()
                ->map(fn (SinonimGejala $item) => [
                    'kata_tidak_baku' => $item->kata_tidak_baku,
                    'kata_baku' => $item->kata_baku,
                    'kode' => $item->gejala?->kode,
                ])
                ->all();

            $hasil = [
                'gejala' => $matcher->ekstrakGejala(
                    $teksNormal,
                    $daftarGejala,
                    $sinonim
                ),
            ];
            $fallbackLokal = true;
        }

        $kodeGejalaValid = collect($daftarGejala)->pluck('kode')->all();
        $kodeGejalaHasil = array_values(array_intersect(
            array_filter($hasil['gejala'] ?? [], 'is_string'),
            $kodeGejalaValid
        ));
        $gejalaDetail = Gejala::whereIn('kode', $kodeGejalaHasil)
            ->get()
            ->map(fn ($g) => ['kode' => $g->kode, 'nama' => $g->nama])
            ->values();

        return response()->json([
            'gejala' => $gejalaDetail,
            'teksNormal' => $teksNormal,
            'fallbackLokal' => $fallbackLokal,
        ]);
    }

    public function proses(Request $request, CertaintyFactorService $cfService)
    {
        $request->validate([
            'teks_asli' => 'required|string',
            'gejala' => 'required|array',
            'gejala.*.kode' => 'required|string',
            'gejala.*.sesuai' => 'required|boolean',
        ]);

        $gejalaTerdeteksi = [];
        $cfPengguna = [];
        foreach ($request->gejala as $g) {
            if ($g['sesuai']) {
                $gejalaTerdeteksi[] = $g['kode'];
                $cfPengguna[$g['kode']] = 1.0;
            }
        }

        if (empty($gejalaTerdeteksi)) {
            return response()->json(['error' => 'Tidak ada gejala dipilih'], 422);
        }

        $hasilCF = $cfService->hitung($gejalaTerdeteksi, $cfPengguna);
        $top = $hasilCF[0] ?? null;

        $penjelasan = '';
        if ($top) {
            $p = $top['penyakit'];
            $persen = round($top['cf_akhir'] * 100, 2);
            $gejalaList = collect($top['gejala_cocok'])
                ->map(fn ($g) => "- {$g['nama']} (CF Pakar: {$g['cf_pakar']}, CF User: {$g['cf_user']})")
                ->implode("\n");

            $penjelasan = "Tanaman cabai Anda terindikasi **{$p->nama}** dengan tingkat keyakinan **{$persen}%**.\n\n"
                ."**Deskripsi:** {$p->deskripsi}\n\n"
                ."**Penyebab:** {$p->penyebab}\n\n"
                ."**Gejala yang teridentifikasi:**\n{$gejalaList}\n\n"
                ."**Rekomendasi Penanganan Awal:** {$p->rekomendasi}";
        }

        RiwayatDiagnosis::create([
            'user_id' => $request->user()->id,
            'input_asli' => $request->teks_asli,
            'gejala_terdeteksi' => $gejalaTerdeteksi,
            'cf_pengguna' => $cfPengguna,
            'penyakit_id' => $top['penyakit_id'] ?? null,
            'cf_akhir' => $top['cf_akhir'] ?? null,
            'penjelasan' => $penjelasan,
        ]);

        return response()->json([
            'hasil' => $hasilCF,
            'top' => $top,
            'penjelasan' => $penjelasan,
        ]);
    }
}
