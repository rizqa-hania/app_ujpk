<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAbsensiScanFieldsToAbsensiTable extends Migration
{
    public function up()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->enum('metode_absensi', ['face', 'qr'])->default('face');
            $table->enum('verifikasi', ['valid', 'invalid'])->nullable();
            $table->boolean('is_valid_radius')->nullable();

            $table->decimal('lat_pulang', 10, 7)->nullable();
            $table->decimal('long_pulang', 10, 7)->nullable();
            $table->float('jarak_pulang')->nullable();

            $table->string('device_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropColumn([
                'metode_absensi',
                'verifikasi',
                'is_valid_radius',
                'lat_pulang',
                'long_pulang',
                'jarak_pulang',
                'device_id',
            ]);
        });
    }
}
