<?php

namespace App\Services;

class SymptomMatcherService
{
    private const RULES = [
        'G01' => [
            [['akar', 'akarnya'], ['coklat', 'cokelat', 'kecoklatan', 'kecokelatan']],
        ],
        'G02' => [
            [['akar', 'akarnya'], ['busuk', 'membusuk', 'pembusukan']],
        ],
        'G09' => [
            [['daun', 'daunnya'], ['bercak', 'totol', 'bintik']],
        ],
        'G13' => [
            [['buah', 'buahnya'], ['hitam', 'kehitaman']],
        ],
        'G14' => [
            [['buah', 'buahnya'], ['keriput', 'kisut']],
        ],
        'G21' => [
            [['daun', 'daunnya'], ['kuning', 'menguning']],
            [['tanaman', 'tanamannya'], ['layu']],
            [['daun', 'daunnya'], ['layu']],
        ],
    ];

    public function ekstrakGejala(
        string $teks,
        array $daftarGejala,
        array $sinonim = []
    ): array {
        $teks = mb_strtolower($teks, 'UTF-8');
        $kodeTersedia = array_fill_keys(
            array_column($daftarGejala, 'kode'),
            true
        );
        $hasil = [];

        foreach ($sinonim as $item) {
            $kode = $item['kode'] ?? null;
            if (! is_string($kode) || ! isset($kodeTersedia[$kode])) {
                continue;
            }

            $kata = array_filter([
                $item['kata_tidak_baku'] ?? null,
                $item['kata_baku'] ?? null,
            ], fn ($value) => is_string($value) && $value !== '');

            foreach ($kata as $kataSinonim) {
                if ($this->mengandungFrasa($teks, mb_strtolower($kataSinonim, 'UTF-8'))) {
                    $hasil[] = $kode;
                    break;
                }
            }
        }

        foreach (self::RULES as $kode => $alternatif) {
            if (! isset($kodeTersedia[$kode])) {
                continue;
            }

            foreach ($alternatif as $kelompok) {
                if ($this->cocokDenganKelompok($teks, $kelompok)) {
                    $hasil[] = $kode;
                    break;
                }
            }
        }

        return array_values(array_unique($hasil));
    }

    private function cocokDenganKelompok(string $teks, array $kelompok): bool
    {
        foreach ($kelompok as $kataAlternatif) {
            $cocok = false;

            foreach ($kataAlternatif as $kata) {
                if ($this->mengandungFrasa($teks, $kata)) {
                    $cocok = true;
                    break;
                }
            }

            if (! $cocok) {
                return false;
            }
        }

        return true;
    }

    private function mengandungFrasa(string $teks, string $frasa): bool
    {
        $pola = '/(?<![\p{L}\p{N}])'.preg_quote($frasa, '/').'(?![\p{L}\p{N}])/u';

        return preg_match($pola, $teks) === 1;
    }
}
