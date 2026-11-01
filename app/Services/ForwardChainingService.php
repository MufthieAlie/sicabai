<?php

namespace App\Services;

class ForwardChainingService
{
    /**
     * Forward Chaining: cocokkan gejala user dengan rule IF-THEN.
     * Mengembalikan daftar penyakit yang aturannya terpenuhi (minimal 1 gejala cocok).
     */
    public function infer(array $gejalaTerdeteksi): array
    {
        // Delegasikan ke CertaintyFactorService untuk perhitungan CF,
        // karena pada dasarnya FC + CF dijalankan bersamaan.
        return []; // placeholder, logika utama ada di CFService
    }
}