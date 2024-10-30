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
        // Tabel untuk user
        Schema::create('maps_user', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key untuk user
            $table->string('address'); // Alamat
            $table->decimal('latitude', 10, 8); // Latitude
            $table->decimal('longitude', 11, 8); // Longitude
            $table->timestamps(); // Timestamps untuk created_at dan updated_at

            // Definisikan foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Tabel untuk recycleorg
        Schema::create('maps_recycleorg', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key untuk user
            $table->string('address'); // Alamat
            $table->decimal('latitude', 10, 8); // Latitude
            $table->decimal('longitude', 11, 8); // Longitude
            $table->timestamps(); // Timestamps untuk created_at dan updated_at

            // Definisikan foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maps_user');
        Schema::dropIfExists('maps_recycleorg');
    }
};
