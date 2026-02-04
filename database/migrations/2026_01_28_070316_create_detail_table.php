<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail', function (Blueprint $table) {
            $table->bigIncrements('detail_id');
            $table->foreignId('penggajian_id')->references('penggajian_id')->on('penggajian');
            // izin yaa riss, gomenn ku ganti
            $table->string('nip', 30);
            $table->foreign('nip')->references('nip')->on('karyawan')->onUpdate('cascade')->onDelete('cascade');
            $table->string('kode',10);
            $table->foreign('kode')->references('kode')->on('komponen');
            $table->decimal('total_penghasilan', 15, 2);
            $table->decimal('total_potongan', 15, 2);
            $table->decimal('gaji_bersih', 15, 2);
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
        Schema::dropIfExists('detail_penggajian');
    }
}
