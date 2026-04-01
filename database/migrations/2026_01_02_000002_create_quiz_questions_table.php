<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_packet_id')->constrained()->cascadeOnDelete();
            $table->text('pertanyaan');
            $table->enum('tipe', ['pilgan', 'uraian', 'benar_salah']);
            $table->text('opsi_a')->nullable();  // pilgan
            $table->text('opsi_b')->nullable();
            $table->text('opsi_c')->nullable();
            $table->text('opsi_d')->nullable();
            $table->string('jawaban_benar')->nullable(); // A/B/C/D atau Benar/Salah atau null (uraian)
            $table->text('pembahasan')->nullable();
            $table->enum('tingkat', ['mudah', 'sedang', 'sulit'])->default('sedang');
            $table->integer('poin')->default(10);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
