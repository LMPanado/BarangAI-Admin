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
            if (!Schema::hasColumn('residents', 'house_no')) {
                $table->string('house_no')->nullable()->after('address');
            }
            if (!Schema::hasColumn('residents', 'street')) {
                $table->string('street')->nullable()->after('house_no');
            }
        });
    }

    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropColumn(array_filter(['house_no', 'street'], fn($c) => Schema::hasColumn('residents', $c)));
        });
    }
};
