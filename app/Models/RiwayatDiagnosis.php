<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatDiagnosis extends Model
{
    protected $table = 'riwayat_diagnosis';
    protected $fillable = ['user_id', 'input_asli', 'gejala_terdeteksi', 'cf_pengguna', 'penyakit_id', 'cf_akhir', 'penjelasan'];
    protected $casts = [
        'gejala_terdeteksi' => 'array',
        'cf_pengguna' => 'array',
    ];

    public function penyakit() { return $this->belongsTo(Penyakit::class); }

    public function user() { return $this->belongsTo(User::class); }
}