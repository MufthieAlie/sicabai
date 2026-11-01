<?php

namespace App\Http\Controllers;

use App\Models\RiwayatDiagnosis;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiagnosisHistoryController extends Controller
{
    public function mine(Request $request)
    {
        return $this->renderHistory($request->user()->riwayatDiagnosis(), false);
    }

    public function team()
    {
        return $this->renderHistory(RiwayatDiagnosis::query(), true);
    }

    private function renderHistory($query, bool $includeUser)
    {
        $history = $query
            ->with($includeUser ? ['penyakit:id,kode,nama', 'user:id,name,email'] : ['penyakit:id,kode,nama'])
            ->latest()
            ->paginate(15)
            ->through(fn (RiwayatDiagnosis $item) => [
                'id' => $item->id,
                'input_asli' => $item->input_asli,
                'gejala_terdeteksi' => $item->gejala_terdeteksi,
                'cf_akhir' => $item->cf_akhir,
                'penjelasan' => $item->penjelasan,
                'created_at' => $item->created_at?->toDateTimeString(),
                'penyakit' => $item->penyakit,
                'user' => $includeUser ? $item->user : null,
            ]);

        return Inertia::render('diagnosis/history', [
            'history' => $history,
            'includeUser' => $includeUser,
        ]);
    }
}
