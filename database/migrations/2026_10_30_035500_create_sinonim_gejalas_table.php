<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sinonim_gejalas', function (Blueprint $table) {
            $table->id();
            $table->string('kata_tidak_baku')->unique(); // "totol-totol", "buruk"
            $table->foreignId('gejala_id')->nullable()->constrained('gejalas')->nullOnDelete();
            $table->string('kata_baku')->nullable(); // "bercak", "busuk"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sinonim_gejalas');
    }
};