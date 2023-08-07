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
            $table->string('name');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('homeroom_teacher_id');
            $table->string('image_url')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('homeroom_teacher_id')->references('id')->on('subject_teachers');
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
