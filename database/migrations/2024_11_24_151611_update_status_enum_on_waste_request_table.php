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
        Schema::table('waste_request', function (Blueprint $table) {
            $table->enum('status', ['pending', 'rejected', 'accepted', 'done'])->change(); // Tambahkan 'done'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('waste_request', function (Blueprint $table) {
            $table->enum('status', ['pending', 'rejected', 'accepted', 'done'])->change(); // Rollback status
        });
    }
};
