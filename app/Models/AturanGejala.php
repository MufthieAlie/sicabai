<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AturanGejala extends Model
{
    protected $table = 'aturan_gejalas';
    protected $fillable = ['penyakit_id', 'gejala_id', 'cf_pakar'];

    public function penyakit() { return $this->belongsTo(Penyakit::class); }
    public function gejala() { return $this->belongsTo(Gejala::class); }
}