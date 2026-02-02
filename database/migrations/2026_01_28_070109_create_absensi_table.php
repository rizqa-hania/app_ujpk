<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->bigIncrements('absensi_id');
            $table->foreignId('nip')->references('nip')->on('karyawan')->unique();
            $table->foreignId('kantor_id')->references('kantor_id') ->on('kantor');
            $table->date('tanggal')->unique();
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->decimal('lat_masuk', 10, 7)->nullable();
            $table->decimal('long_masuk', 10, 7)->nullable();
            $table->float('jarak_masuk')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'hamil', 'alpha', 'lembur' ]);
            $table->timestamps();
        });
          
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi');
    }
}
