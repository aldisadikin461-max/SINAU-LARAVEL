<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('Guru yang upload');
            $table->string('judul');
            $table->string('penulis')->nullable();
            $table->string('file_path');
            $table->string('cover')->nullable();
            $table->string('jurusan')->nullable()->comment('Kosong = semua jurusan');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('total_views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ebooks');
    }
};