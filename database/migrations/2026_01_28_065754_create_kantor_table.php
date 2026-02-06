<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKantorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kantor', function (Blueprint $table) {
            $table->bigIncrements('kantor_id');
            $table->string('nama_kantor');
            $table->string('alamat')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude',10,7);
            $table->integer('radius_meter')->default(100);
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
        Schema::dropIfExists('kantor');
    }
}
