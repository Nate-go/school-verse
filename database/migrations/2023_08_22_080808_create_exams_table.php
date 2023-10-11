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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_teacher_id');
            $table->string('content');
            $table->integer('type');
            $table->integer('exam_status');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('room_teacher_id')->references('id')->on('room_teachers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
