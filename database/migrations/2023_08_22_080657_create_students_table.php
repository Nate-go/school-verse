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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('school_year_id');
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('scores', 500)->nullable();          
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('school_year_id')->references('id')->on('school_years');
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
