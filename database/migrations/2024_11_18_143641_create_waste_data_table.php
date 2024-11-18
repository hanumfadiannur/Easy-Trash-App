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
        Schema::create('waste_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wasteRequestID'); // Mengacu ke waste_requests
            $table->unsignedBigInteger('userID'); // Mengacu ke users
            $table->integer('total_weight')->default(0); // Total berat sampah
            $table->integer('points')->default(0); // Poin yang dihitung dari total_weight * 100
            $table->timestamps();

            // Menambahkan relasi foreign key
            $table->foreign('wasteRequestID')->references('id')->on('waste_request')->onDelete('cascade');
            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_data');
    }
};
