<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa')->after('email');
            $table->string('phone')->nullable()->after('role')->comment('Nomor WA siswa/guru');
            $table->string('jurusan')->nullable()->after('phone');
            $table->string('kelas')->nullable()->after('jurusan');
            $table->unsignedBigInteger('total_poin')->default(0)->after('kelas');
            $table->unsignedTinyInteger('level')->default(1)->after('total_poin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'jurusan', 'kelas', 'total_poin', 'level']);
        });
    }
};