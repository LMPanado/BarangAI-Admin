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
        $table->date('schedule_date');
        $table->time('schedule_time'); 
        $table->time('schedule_time_to'); // Matches your form 'name' attribute
        $table->string('location')->nullable(); // Added this because it's in your Model/Controller
        $table->text('description')->nullable();
        $table->string('image')->nullable();
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
