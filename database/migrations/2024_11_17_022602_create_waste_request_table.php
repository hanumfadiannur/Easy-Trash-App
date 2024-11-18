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
        Schema::create('waste_request', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // Menyimpan user_id
            $table->unsignedBigInteger('recycleorgID');  // Menyimpan recycleorgID
            $table->enum('status', ['pending', 'accepted', 'rejected']);  // Status permintaan sampah
            $table->date('expiryDate');  // Tanggal kadaluarsa (misalnya 2 hari setelah created_at)
            $table->timestamps();

            // Menambahkan foreign key constraint untuk user_id dan recycleorgID
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  // Relasi ke users, user yang membuat request
            $table->foreign('recycleorgID')->references('id')->on('users')->onDelete('cascade');  // Relasi ke users, recycleorg yang menerima request
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_request');
    }
};
