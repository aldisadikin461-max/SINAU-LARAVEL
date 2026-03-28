<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tryouts', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->unsignedInteger('durasi_menit')->default(60);
            $table->dateTime('tanggal_mulai')->nullable();
            $table->dateTime('tanggal_selesai')->nullable();
            $table->timestamps();
        });

        Schema::create('tryout_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tryout_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tryout_questions');
        Schema::dropIfExists('tryouts');
    }
};
