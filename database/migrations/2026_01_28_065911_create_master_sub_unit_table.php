<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterSubUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_sub_unit', function (Blueprint $table) {
    $table->bigIncrements('sub_id');

    $table->unsignedBigInteger('unitpln_id');
    $table->foreign('unitpln_id')->references('unitpln_id')->on('master_unit_pln')->onDelete('cascade');

    $table->string('kode_sub')->unique();
    $table->string('nama_sub_unit');
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
        Schema::dropIfExists('master_sub_unit');
    }
}
