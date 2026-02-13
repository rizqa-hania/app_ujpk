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
    $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
    $table->enum('jenis_izin', ['sakit','izin','kehamilan','cuti_lainnya']);
    $table->date('tanggal_mulai');
    $table->date('tanggal_selesai');
    $table->string('bukti_dokumen')->nullable();
    $table->text('keterangan')->nullable();
    $table->unique(['karyawan_id', 'tanggal_mulai', 'tanggal_selesai']);
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
