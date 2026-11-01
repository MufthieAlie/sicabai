<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('riwayat_diagnosis', function (Blueprint $table) {
            $table->id();
            $table->text('input_asli'); // teks mentah dari user
            $table->json('gejala_terdeteksi'); // ["G09","G02"]
            $table->json('cf_pengguna'); // {"G09": 1.0, "G02": 0.6}
            $table->foreignId('penyakit_id')->nullable()->constrained('penyakits')->nullOnDelete();
            $table->decimal('cf_akhir', 4, 2)->nullable();
            $table->text('penjelasan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_diagnosis');
    }
};