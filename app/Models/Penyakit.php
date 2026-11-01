<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    protected $fillable = ['kode', 'nama', 'deskripsi', 'penyebab', 'rekomendasi'];

    public function gejalas()
    {
        return $this->belongsToMany(Gejala::class, 'aturan_gejalas')
                    ->withPivot('cf_pakar')
                    ->withTimestamps();
    }
}