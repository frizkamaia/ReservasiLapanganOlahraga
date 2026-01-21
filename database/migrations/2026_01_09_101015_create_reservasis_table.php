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
            $table->id();

            $table->foreignId('user_id')
                ->constrained('user')
                ->onDelete('cascade');

            $table->foreignId('lapangan_id')
                ->constrained('lapangans')
                ->onDelete('cascade');

            $table->foreignId('jadwal_id')
                ->constrained('jadwals')
                ->onDelete('cascade');

            $table->enum('tipe_sewa', ['harian', 'jam']);

            // pilihan user
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();

            $table->integer('total_harga');

            $table->enum('status', [
                'pending',
                'disetujui',
                'ditolak',
                'selesai',
            ])->default('pending');

            $table->timestamps();
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
