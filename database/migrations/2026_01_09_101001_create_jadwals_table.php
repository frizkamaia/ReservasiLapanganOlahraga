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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lapangan_id')
                ->constrained('lapangans')
                ->onDelete('cascade');

            // batas ketersediaan
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            // jam opsional (kalau lapangan dibatasi jam)
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();

            $table->enum('status', ['available', 'booked'])->default('available');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
