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
        Schema::create('category_waste_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wasteDataID');  // Mengacu ke waste_data
            $table->unsignedBigInteger('categoryID');   // Mengacu ke waste_categories
            $table->integer('weight');  // Berat untuk kategori ini
            $table->timestamps();

            $table->foreign('wasteDataID')->references('id')->on('waste_data')->onDelete('cascade');
            $table->foreign('categoryID')->references('id')->on('waste_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_waste_data');
    }
};
