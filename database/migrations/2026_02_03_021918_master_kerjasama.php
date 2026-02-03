<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MasterKerjasama extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_kerja_sama', function (Blueprint $table) {
    $table->bigIncrements('kerjasama_id');

    $table->unsignedBigInteger('unitpln_id');
    $table->foreign('unitpln_id')->references('unitpln_id')->on('master_unit_pln')->onDelete('cascade');
    $table->string('nama_kerja_sama');
    $table->string('mitra');
    $table->string('jenis_kerjasama');
    $table->boolean('is_active')->default(true);

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
        //
    }
}
