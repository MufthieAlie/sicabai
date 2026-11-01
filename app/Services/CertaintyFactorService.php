<?php

namespace App\Services;

use App\Models\AturanGejala;

class CertaintyFactorService
{
    /**
     * Hitung CF akhir untuk setiap penyakit berdasarkan gejala terdeteksi & CF pengguna.
     *
     * @param  array $gejalaTerdeteksi  ['G01','G02']
     * @param  array $cfPengguna        ['G01' => 1.0, 'G02' => 0.6]
     * @return array  [['penyakit_id'=>1,'cf_akhir'=>0.87,'gejala_cocok'=>[...]], ...]
     */
    public function hitung(array $gejalaTerdeteksi, array $cfPengguna): array
    {
        $aturan = AturanGejala::with(['penyakit', 'gejala'])
            ->whereIn('gejala_id', function ($q) use ($gejalaTerdeteksi) {
                $q->select('id')->from('gejalas')->whereIn('kode', $gejalaTerdeteksi);
            })
            ->get()
            ->groupBy('penyakit_id');

        $hasil = [];
        foreach ($aturan as $penyakitId => $list) {
            $cfOld = 0.0;
            $gejalaCocok = [];
            foreach ($list as $a) {
                $kodeGejala = $a->gejala->kode;
                $cfPakar    = (float) $a->cf_pakar;
                $cfUser     = (float) ($cfPengguna[$kodeGejala] ?? 0);
                $cfGejala   = $cfPakar * $cfUser;

                if ($cfGejala <= 0) continue;

                // Kombinasi CF
                if ($cfOld == 0.0) {
                    $cfOld = $cfGejala;
                } else {
                    $cfOld = $cfOld + $cfGejala * (1 - $cfOld);
                }
                $gejalaCocok[] = [
                    'kode' => $kodeGejala,
                    'nama' => $a->gejala->nama,
                    'cf_pakar' => $cfPakar,
                    'cf_user' => $cfUser,
                    'cf_gejala' => round($cfGejala, 4),
                ];
            }

            if (!empty($gejalaCocok)) {
                $hasil[] = [
                    'penyakit_id' => $penyakitId,
                    'penyakit' => $list->first()->penyakit,
                    'cf_akhir' => round($cfOld, 4),
                    'gejala_cocok' => $gejalaCocok,
                ];
            }
        }

        // Urutkan dari CF tertinggi
        usort($hasil, fn($a, $b) => $b['cf_akhir'] <=> $a['cf_akhir']);
        return $hasil;
    }
}