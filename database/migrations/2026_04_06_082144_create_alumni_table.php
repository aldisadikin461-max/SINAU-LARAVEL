<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kampus');
            $table->string('domain_kampus')->nullable();
            $table->string('jurusan');
            $table->enum('jalur', ['SNBP', 'SNBT', 'Mandiri'])->default('SNBP');
            $table->year('tahun_lulus');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};