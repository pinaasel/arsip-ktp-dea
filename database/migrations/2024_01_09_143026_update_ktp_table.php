<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ktps', function (Blueprint $table) {
            // Data Pribadi
            $table->string('tempat_lahir')->after('nama_lengkap');
            $table->date('tanggal_lahir')->after('tempat_lahir');
            $table->enum('jenis_kelamin', ['L', 'P'])->after('tanggal_lahir');
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', '-'])->after('jenis_kelamin');
            
            // Alamat Detail
            $table->string('rt', 3)->after('alamat');
            $table->string('rw', 3)->after('rt');
            $table->string('kelurahan')->after('rw');
            $table->string('kecamatan')->after('kelurahan');
            $table->string('kota')->after('kecamatan');
            $table->string('provinsi')->after('kota');
            $table->string('kode_pos', 5)->after('provinsi');
            
            // Info Tambahan
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'])->after('kode_pos');
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'])->after('agama');
            $table->string('pekerjaan')->after('status_perkawinan');
            $table->enum('kewarganegaraan', ['WNI', 'WNA'])->after('pekerjaan');
            $table->date('berlaku_hingga')->after('status');
        });
    }

    public function down()
    {
        Schema::table('ktps', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'golongan_darah',
                'rt',
                'rw',
                'kelurahan',
                'kecamatan',
                'kota',
                'provinsi',
                'kode_pos',
                'agama',
                'status_perkawinan',
                'pekerjaan',
                'kewarganegaraan',
                'berlaku_hingga'
            ]);
        });
    }
};
