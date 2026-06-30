<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('announcements', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('feedback', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('schedules', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('residents',      fn($t) => $t->dropSoftDeletes());
        Schema::table('announcements',  fn($t) => $t->dropSoftDeletes());
        Schema::table('feedback',       fn($t) => $t->dropSoftDeletes());
        Schema::table('schedules',      fn($t) => $t->dropSoftDeletes());
    }
};
