<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailKomponenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_komponen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('detail_id')->references('detail_id')->on('detail');
            $table->string('kode');
            $table->foreign('kode')->references('kode')->on('komponen')->onDelete('cascade');
            $table->decimal('nilai', 15, 2);
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
        Schema::dropIfExists('detail_komponen');
    }
}
