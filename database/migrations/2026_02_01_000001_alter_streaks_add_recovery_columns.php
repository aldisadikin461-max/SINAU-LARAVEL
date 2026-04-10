<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('streaks', function (Blueprint $table) {
            if (!Schema::hasColumn('streaks', 'current_streak')) {
                $table->unsignedInteger('current_streak')->default(0)->after('streak_count');
            }
            if (!Schema::hasColumn('streaks', 'last_activity_at')) {
                $table->timestamp('last_activity_at')->nullable()->after('current_streak');
            }
            if (!Schema::hasColumn('streaks', 'last_increase_at')) {
                $table->timestamp('last_increase_at')->nullable()->after('last_activity_at');
            }
            if (!Schema::hasColumn('streaks', 'started_at')) {
                $table->timestamp('started_at')->nullable()->after('last_increase_at');
            }
            if (!Schema::hasColumn('streaks', 'recovery_used_this_month')) {
                $table->tinyInteger('recovery_used_this_month')->default(0)->after('started_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('streaks', function (Blueprint $table) {
            $cols = ['current_streak', 'last_activity_at', 'last_increase_at', 'started_at', 'recovery_used_this_month'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('streaks', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
