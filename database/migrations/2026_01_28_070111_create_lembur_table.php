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

        $table->string('nip', 30);
        $table->foreign('nip')
            ->references('nip')
            ->on('karyawan')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai');
        $table->time('jam_mulai');
        $table->time('jam_selesai');
        $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
        $table->text('keterangan')->nullable();
        $table->unique(['nip', 'tanggal_mulai', 'jam_mulai']);
        $table->timestamps();
    });

    }

    public function down()
    {
        Schema::dropIfExists('lembur');
    }
}
