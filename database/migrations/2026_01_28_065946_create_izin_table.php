<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIzinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('izin', function (Blueprint $table) {
            $table->bigIncrements('izin_id');
            $table->foreignId('karyawan_id')->references('karyawan_id')->on('karyawan');
            $table->enum('jenis',['izin','sakit','hamil']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('bukti_dokumen')->nullable();
            $table->enum('status',['proses','disetujui','ditolak']);
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
        Schema::dropIfExists('izin');
    }
}
