<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaint_messages', function (Blueprint $table) {
            $table->string('sender_type')->default('admin')->after('message'); // 'admin' or 'resident'
            $table->string('sender_name')->nullable()->after('sender_type');
            $table->integer('admin_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('complaint_messages', function (Blueprint $table) {
            $table->dropColumn(['sender_type', 'sender_name']);
        });
    }
};
