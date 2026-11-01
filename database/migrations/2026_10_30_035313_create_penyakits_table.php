<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penyakits', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // P01, P02
            $table->string('nama');
            $table->text('deskripsi');
            $table->text('penyebab');
            $table->text('rekomendasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyakits');
    }
};