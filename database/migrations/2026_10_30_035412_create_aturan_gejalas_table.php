<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('aturan_gejalas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyakit_id')->constrained('penyakits')->cascadeOnDelete();
            $table->foreignId('gejala_id')->constrained('gejalas')->cascadeOnDelete();
            $table->decimal('cf_pakar', 4, 2); // 0.00 - 1.00
            $table->timestamps();
            $table->unique(['penyakit_id', 'gejala_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aturan_gejalas');
    }
};