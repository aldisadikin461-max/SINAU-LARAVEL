<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rasionalisasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('mode', ['kuliah', 'kerja']);
            $table->json('input_data');
            $table->json('hasil_ai')->nullable();
            $table->unsignedTinyInteger('skor_kesiapan')->nullable();
            $table->enum('status', ['pending', 'selesai', 'gagal'])->default('selesai');
            $table->timestamps();
        });

        Schema::create('rasionalisasi_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rasionalisasi_id')->constrained('rasionalisasi')->cascadeOnDelete();
            $table->string('tipe'); // kampus | karir
            $table->string('nama');
            $table->string('link')->nullable();
            $table->json('data_extra')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rasionalisasi_bookmarks');
        Schema::dropIfExists('rasionalisasi');
    }
};
