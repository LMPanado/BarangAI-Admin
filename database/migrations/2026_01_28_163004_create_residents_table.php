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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            
            // 1. Link to the Users table (Foreign Key)
            // This is critical for connecting logins to profiles
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            // 2. Name details
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            
            // 3. Contact & Profile details
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->integer('age');
            $table->string('gender');
            $table->string('civil_status')->nullable();
            $table->text('address'); // Use text for longer addresses
            
            // 4. Logic & Records fields
            $table->boolean('is_voter')->default(false);
            $table->date('birth_date')->nullable();
            $table->string('place_birth')->nullable();
            
            // 5. Physical attributes (Matches your Resident.php model)
            $table->string('height_cm')->nullable();
            $table->string('weight_kg')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};