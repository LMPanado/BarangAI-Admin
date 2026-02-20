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
    Schema::create('schedules', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->date('schedule_date'); // The date of the event
        $table->time('schedule_time')->nullable(); // ADD THIS LINE: Fixes the 'Column not found' error
        $table->time('schedule_time_to'); // Ensure this exists
        $table->time('end_time')->nullable();
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
