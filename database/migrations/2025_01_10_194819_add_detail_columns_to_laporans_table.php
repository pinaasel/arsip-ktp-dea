<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('laporans', function (Blueprint $table) {
            // Kolom untuk laporan kehilangan
            $table->string('lokasi_kehilangan')->nullable()->after('keterangan');
            $table->date('tanggal_kehilangan')->nullable()->after('lokasi_kehilangan');
            
            // Kolom untuk laporan kerusakan
            $table->text('detail_kerusakan')->nullable()->after('tanggal_kehilangan');
            
            // Kolom untuk laporan pembaruan
            $table->string('alasan_pembaruan')->nullable()->after('detail_kerusakan');
        });
    }

    public function down()
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn([
                'lokasi_kehilangan',
                'tanggal_kehilangan',
                'detail_kerusakan',
                'alasan_pembaruan'
            ]);
        });
    }
};
