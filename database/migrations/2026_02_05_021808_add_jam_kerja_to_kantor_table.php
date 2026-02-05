<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJamKerjaToKantorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kantor', function (Blueprint $table) {
    $table->time('jam_masuk_mulai')->default('07:00:00');
    $table->time('jam_masuk_selesai')->default('09:00:00');
    $table->time('jam_pulang_mulai')->default('16:00:00');
    $table->time('jam_pulang_selesai')->default('18:00:00');
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kantor', function (Blueprint $table) {
            //
        });
    }
}
