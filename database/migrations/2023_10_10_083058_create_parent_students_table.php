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
        Schema::create('parent_students', function (Blueprint $table) {
            $table->id();
            $table->integer('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('phonenumber')->nullable();
            $table->string('relationship')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
