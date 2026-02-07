<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
{
    Schema::table('residents', function (Blueprint $table) {
        $table->string('middle_name')->nullable();
        $table->string('civil_status')->nullable();
        $table->date('birth_date')->nullable();
        $table->string('place_birth')->nullable();
        $table->integer('height_cm')->nullable();
        $table->integer('weight_kg')->nullable();
        $table->boolean('is_voter')->default(false);
    });
}
};
