<?php

namespace App\Http\Controllers;

use App\Models\AturanGejala;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\RiwayatDiagnosis;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('dashboard', [
            'stats' => [
                'users' => User::where('role', 'user')->count(),
                'penyakit' => Penyakit::count(),
                'gejalas' => Gejala::count(),
                'rules' => AturanGejala::count(),
                'diagnoses' => RiwayatDiagnosis::count(),
            ],
        ]);
    }
}