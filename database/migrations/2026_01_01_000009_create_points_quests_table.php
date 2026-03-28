<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('poin');
            $table->string('aktivitas');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('deskripsi')->nullable();
            $table->unsignedInteger('target')->default(1);
            $table->unsignedInteger('poin_reward')->default(20);
            $table->string('tipe'); // jawab_soal, baca_ebook, dll
            $table->timestamps();
        });

        Schema::create('user_quests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('quest_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('progress')->default(0);
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_quests');
        Schema::dropIfExists('quests');
        Schema::dropIfExists('user_points');
    }
};
