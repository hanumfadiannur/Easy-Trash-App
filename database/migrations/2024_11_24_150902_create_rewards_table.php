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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Nama reward
            $table->text('description')->nullable(); // Deskripsi reward
            $table->integer('points_required'); // Poin yang diperlukan untuk menukarkan
            $table->integer('stock'); // Stok reward yang tersedia
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
