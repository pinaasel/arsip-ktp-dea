<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ktps', function (Blueprint $table) {
            if (!Schema::hasColumn('ktps', 'petugas_id')) {
                $table->unsignedBigInteger('petugas_id')->nullable();
                $table->foreign('petugas_id')->references('id')->on('users');
            }
        });
    }

    public function down()
    {
        Schema::table('ktps', function (Blueprint $table) {
            $table->dropForeign(['petugas_id']);
            $table->dropColumn('petugas_id');
        });
    }
};
