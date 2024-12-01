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
        Schema::create('reward_transactions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // User yang menukar
            $table->unsignedBigInteger('reward_id'); // Reward yang ditukar
            $table->integer('points_used'); // Poin yang digunakan untuk penukaran
            $table->timestamps();

            // Relasi dengan tabel user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Relasi dengan tabel rewards
            $table->foreign('reward_id')->references('id')->on('rewards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward_transactions');
    }
};
