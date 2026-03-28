<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('judul');
            $table->date('target_date');
            $table->enum('status', ['pending', 'done'])->default('pending');
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->string('jurusan')->nullable();
            $table->string('kelas')->nullable();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->dateTime('deadline');
            $table->timestamps();
        });

        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('penyelenggara');
            $table->enum('jenjang', ['SMA', 'SMK', 'S1']);
            $table->string('tipe');
            $table->date('deadline');
            $table->string('link');
            $table->enum('status', ['buka', 'tutup'])->default('buka');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('scholarship_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('scholarships');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('study_plans');
    }
};
