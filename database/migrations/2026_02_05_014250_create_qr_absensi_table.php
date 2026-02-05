<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('qr_absensi', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('kantor_id');
    $table->string('token', 255)->unique();
    $table->date('tanggal');
    $table->time('expired_at');
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
        Schema::dropIfExists('qr_absensi');
    }
}
