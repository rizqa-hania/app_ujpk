<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomponenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komponen', function (Blueprint $table) {
            $table->bigIncrements('kode');
            $table->string('name');
            $table->enum('tipe', ['penghasilan', 'potongan']);
            $table->enum('tipe_penghitungan', ['tetap', 'presentase']);
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
        Schema::dropIfExists('komponen_penggajian');
    }
}
