<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');         // created | updated | deleted | status_changed | role_changed | login | logout
            $table->string('subject_type');   // Announcement | Resident | Schedule | DocumentRequest | User
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('subject_label');  // human-readable name of the affected record
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
