<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kemitraan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('logo')->nullable(); // path file upload
            $table->string('bidang');
            $table->string('link_website')->nullable();
            $table->text('lowongan')->nullable();
            $table->string('link_lowongan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kemitraan');
    }
};