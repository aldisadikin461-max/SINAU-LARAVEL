<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_packet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('skor')->default(0);
            $table->integer('total_poin')->default(0);
            $table->integer('benar')->default(0);
            $table->integer('salah')->default(0);
            $table->integer('uraian_count')->default(0); // jumlah soal uraian (dinilai manual)
            $table->json('jawaban')->nullable(); // {question_id: jawaban_siswa}
            $table->timestamp('selesai_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};