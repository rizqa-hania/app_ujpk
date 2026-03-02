<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalAbsensisTable extends Migration
{
    public function up()
    {
        Schema::create('jadwal_absensis', function (Blueprint $table) {
            $table->bigIncrements('jadwal_id');

            $table->boolean('senin')->default(true);
            $table->time('jam_masuk_senin')->nullable();
            $table->time('jam_pulang_senin')->nullable();

            $table->boolean('selasa')->default(true);
            $table->time('jam_masuk_selasa')->nullable();
            $table->time('jam_pulang_selasa')->nullable();

            $table->boolean('rabu')->default(true);
            $table->time('jam_masuk_rabu')->nullable();
            $table->time('jam_pulang_rabu')->nullable();

            $table->boolean('kamis')->default(true);
            $table->time('jam_masuk_kamis')->nullable();
            $table->time('jam_pulang_kamis')->nullable();

            $table->boolean('jumat')->default(true);
            $table->time('jam_masuk_jumat')->nullable();
            $table->time('jam_pulang_jumat')->nullable();

            $table->boolean('sabtu')->default(false);
            $table->time('jam_masuk_sabtu')->nullable();
            $table->time('jam_pulang_sabtu')->nullable();

            $table->boolean('minggu')->default(false);
            $table->time('jam_masuk_minggu')->nullable();
            $table->time('jam_pulang_minggu')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_absensis');
    }
}