<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ktps', function (Blueprint $table) {
            // Only rename if 'foto' exists and 'foto_ktp' doesn't exist
            if (Schema::hasColumn('ktps', 'foto') && !Schema::hasColumn('ktps', 'foto_ktp')) {
                $table->renameColumn('foto', 'foto_ktp');
            }
        });
    }

    public function down()
    {
        Schema::table('ktps', function (Blueprint $table) {
            if (Schema::hasColumn('ktps', 'foto_ktp') && !Schema::hasColumn('ktps', 'foto')) {
                $table->renameColumn('foto_ktp', 'foto');
            }
        });
    }
};
