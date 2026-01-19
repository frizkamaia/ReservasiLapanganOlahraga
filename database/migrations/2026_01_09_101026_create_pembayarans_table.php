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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id(); // id : int
            // reservasi_id : int (FK)
            $table->foreignId('reservasi_id')->constrained('reservasis')->onDelete('cascade');
            // metode : enum (transfer, cash)
            $table->enum('metode', ['transfer', 'cash']);
            $table->integer('jumlah'); // jumlah : int
            $table->string('bukti_transfer')->nullable(); // bukti_transfer : string
            // status : enum (valid, tidak valid)
            $table->enum('status', ['valid', 'tidak valid'])->default('tidak valid');
            $table->timestamp('created_at')->nullable(); // created_at : timestamp
            $table->timestamp('updated_at')->nullable(); // updated_at : timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
