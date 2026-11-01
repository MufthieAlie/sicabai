<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    protected $fillable = ['kode', 'nama'];

    public function penyakits()
    {
        return $this->belongsToMany(Penyakit::class, 'aturan_gejalas')
                    ->withPivot('cf_pakar')
                    ->withTimestamps();
    }

    public function sinonim()
    {
        return $this->hasMany(SinonimGejala::class);
    }
}