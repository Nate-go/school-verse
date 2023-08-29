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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('role');
            $table->string('username');
            $table->string('image_url')->nullable();
            $table->integer('status');
            $table->rememberToken()->nullable();
            $table->unsignedBigInteger('profile_id')->unique();
            $table->timestamps();
            $table->timestamp('delete_at')->nullable();

            $table->foreign('profile_id')->references('id')->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
