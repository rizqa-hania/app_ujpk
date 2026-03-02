<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIzinsTable extends Migration
{
    public function up()
    {
        Schema::create('izins', function (Blueprint $table) {

            $table->bigIncrements('izin_id');
            $table->unsignedBigInteger('user_id');

            // TAMBAHAN
            $table->enum('jenis', ['izin','cuti','sakit']);

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->text('keterangan');
            $table->string('file_bukti')->nullable();

            $table->enum('status', ['pending','disetujui','ditolak'])
                  ->default('pending');

            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('izins');
    }
}