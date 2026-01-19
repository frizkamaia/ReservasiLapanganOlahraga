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
    Schema::table('reservasis', function (Blueprint $table) {
        $table->enum('tipe_sewa', ['harian','jam'])->after('lapangan_id');
        $table->date('tanggal_mulai')->nullable()->after('tipe_sewa');
        $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
        $table->time('jam_mulai')->nullable()->after('tanggal_selesai');
        $table->time('jam_selesai')->nullable()->after('jam_mulai');
    });
}

public function down(): void
{
    Schema::table('reservasis', function (Blueprint $table) {
        $table->dropColumn([
            'tipe_sewa',
            'tanggal_mulai',
            'tanggal_selesai',
            'jam_mulai',
            'jam_selesai'
        ]);
    });
}
};
