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
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id(); // id : int
            // user_id : int (FK)
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            // jadwal_id : int (FK)
            $table->foreignId('jadwal_id')->constrained('jadwals')->onDelete('cascade');
            // lapangan_id : int (FK)
            $table->foreignId('lapangan_id')->constrained('lapangans')->onDelete('cascade');
            $table->integer('total_harga'); // total_harga : int
            // status : enum (pending, disetujui, ditolak, selesai)
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'selesai'])->default('pending');
            $table->timestamp('created_at')->nullable(); // created_at : timestamp
            $table->timestamp('updated_at')->nullable(); // updated_at : timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
