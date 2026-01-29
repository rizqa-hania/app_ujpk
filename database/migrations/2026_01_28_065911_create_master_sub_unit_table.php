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
            $table->foreignId('unitpln_id')->refences('unitpln_id')->on('master_unit_pln');
            $table->string('kode_sub')->unique();
            $table->string('nama_sub');
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
