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
            $table->id(); // id : int
            // lapang_id : int (FK)
            $table->foreignId('lapangan_id')->constrained('lapangans')->onDelete('cascade');
            $table->date('tanggal'); // tanggal : date
            $table->string('jam_mulai'); // jam_mulai : time
            $table->string('jam_selesai'); // jam_selesai : time
            // status : enum (available, booked)
            $table->enum('status', ['available', 'booked'])->default('available');
            $table->timestamp('created_at')->nullable(); // created_at : timestamp
            $table->timestamp('updated_at')->nullable(); // updated_at : timestamp
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
