<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->date('tanggal');

            $table->time('jam_masuk')->nullable();
            $table->string('status_masuk', 50)->nullable();

            $table->time('jam_pulang')->nullable();
            $table->string('status_pulang', 50)->nullable();

            $table->string('status_final', 100)->nullable();

            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->timestamps();

            $table->unique(['user_id','tanggal']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensis');
    }
}