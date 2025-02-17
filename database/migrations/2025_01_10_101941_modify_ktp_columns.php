<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First add new columns without dropping the old ones
        Schema::table('ktps', function (Blueprint $table) {
            $table->string('rt_rw', 10)->nullable()->after('alamat');
            $table->string('kel_desa')->nullable()->after('rt_rw');
            // Add these columns if they don't exist
            if (!Schema::hasColumn('ktps', 'kota')) {
                $table->string('kota')->after('kecamatan');
            }
            if (!Schema::hasColumn('ktps', 'provinsi')) {
                $table->string('provinsi')->after('kota');
            }
            if (!Schema::hasColumn('ktps', 'kode_pos')) {
                $table->string('kode_pos', 5)->after('provinsi');
            }
        });

        // Then drop the old columns
        Schema::table('ktps', function (Blueprint $table) {
            $table->dropColumn([
                'rt',
                'rw',
                'kelurahan'
            ]);
        });
    }

    public function down()
    {
        Schema::table('ktps', function (Blueprint $table) {
            // Add back old columns
            $table->string('rt', 3)->after('alamat');
            $table->string('rw', 3)->after('rt');
            $table->string('kelurahan')->after('rw');
            
            // Remove new columns
            $table->dropColumn(['rt_rw', 'kel_desa', 'kota', 'provinsi', 'kode_pos']);
        });
    }
};
