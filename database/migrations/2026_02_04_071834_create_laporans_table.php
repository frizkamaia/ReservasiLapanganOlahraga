<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reservasi_id')->constrained()->cascadeOnDelete();

            $table->date('tanggal');
            $table->integer('total_jam')->nullable(); // untuk sewa per jam
            $table->integer('total_hari')->nullable(); // untuk sewa harian
            $table->integer('total_bayar');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
