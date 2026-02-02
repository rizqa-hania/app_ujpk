<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLemburTable extends Migration
{
    public function up()
    {
        Schema::create('lembur', function (Blueprint $table) {
            $table->bigIncrements('lembur_id');

            $table->string('nip');

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->time('jam_mulai');
            $table->time('jam_selesai');

            $table->enum('status', ['pending', 'disetujui', 'ditolak'])
                  ->default('pending');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            // aktifkan kalau tabel pegawai sudah fix
            // $table->foreign('nip')->references('nip')->on('pegawai');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lembur');
    }
}
