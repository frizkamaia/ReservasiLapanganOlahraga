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
        Schema::create('lapangans', function (Blueprint $table) {
            $table->id(); // id : int
            $table->string('nama_lapangan'); // nama_lapangan : string
            $table->string('jenis'); // jenis : string
            $table->string('foto')->nullable(); // foto : string
            $table->integer('harga_per_jam'); // harga_per_jam : int
            $table->text('deskripsi')->nullable(); // deskripsi : text
            $table->timestamp('created_at')->nullable(); // created_at : timestamp
            $table->timestamp('updated_at')->nullable(); // updated_at : timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangans');
    }
};
