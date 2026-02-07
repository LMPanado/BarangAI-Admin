<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            // Adds the 'To' time column right after the existing time column
            $table->time('schedule_time_to')->nullable()->after('schedule_time');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            // Removes the column if you rollback the migration
            $table->dropColumn('schedule_time_to');
        });
    }
};