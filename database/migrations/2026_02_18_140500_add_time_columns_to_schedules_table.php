<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            // Only add schedule_time if it DOES NOT exist
            if (!Schema::hasColumn('schedules', 'schedule_time')) {
                $table->time('schedule_time')->nullable()->after('schedule_date');
            }

            // Only add schedule_time_to if it DOES NOT exist
            if (!Schema::hasColumn('schedules', 'schedule_time_to')) {
                $table->time('schedule_time_to')->nullable()->after('schedule_time');
            }
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['schedule_time', 'schedule_time_to']);
        });
    }
};