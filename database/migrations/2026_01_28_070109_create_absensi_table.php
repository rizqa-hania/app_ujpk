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
            $table->foreignId('nip')->references('nip')->on('karyawan');
            $table->foreignId('kantor_id')->references('kantor_id') ->on('kantor');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->decimal('lat_masuk', 10, 7)->nullable();
            $table->decimal('long_masuk', 10, 7)->nullable();
            $table->float('jarak_masuk')->nullable();
            $table->enum('status', [
            'hadir',
            'izin',
            'sakit',
            'hamil',
            'alpha',
            'lembur'
        ]);

            $table->timestamps();
<<<<<<< HEAD:database/migrations/2026_01_28_041702_create_absensi_table.php
             $table->unique(['nip', 'tanggal']);
=======

            $table->unique(['nip', 'tanggal']);
>>>>>>> 9a6b93d8130c25ca1e42f8ede4404508cc6b8e34:database/migrations/2026_01_28_070109_create_absensi_table.php
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
