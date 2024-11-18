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
        Schema::create('waste_category', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Jenis sampah (contoh: botol kaca, botol plastik, kardus)
            $table->timestamps();
        });
    }

    /**
     *
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_category');
    }
};
