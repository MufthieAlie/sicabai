<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinonimGejala extends Model
{
    protected $fillable = ['kata_tidak_baku', 'gejala_id', 'kata_baku'];

    public function gejala() { return $this->belongsTo(Gejala::class); }
}