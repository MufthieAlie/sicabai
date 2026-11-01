<?php

namespace App\Services;

use App\Models\SinonimGejala;

class FuzzyService
{
    /**
     * Normalisasi teks SEBELUM dikirim ke LLM.
     * Hanya ganti sinonim eksplisit dari database (tanpa Levenshtein agresif).
     */
    public function normalize(string $teks): string
    {
        $teks = strtolower($teks);

        $sinonim = SinonimGejala::whereNotNull('kata_baku')->get();
        foreach ($sinonim as $s) {
            $teks = str_replace(strtolower($s->kata_tidak_baku), $s->kata_baku, $teks);
        }

        return $teks;
    }
}