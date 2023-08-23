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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('school_year_id');
            $table->unsignedBigInteger('homeroom_teacher_id');
            $table->string('name');
            $table->string('image_url')->nullable();
            $table->timestamps();
            $table->timestamp('delete_at')->nullable();

            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('school_year_id')->references('id')->on('school_years');
            $table->foreign('homeroom_teacher_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
