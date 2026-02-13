<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
    $table->bigIncrements('absensi_id');

    // ku ganti ternyata harusnya id dan kalau nip itu kan bisa berubah2 jadi nya bisa aja kita harus ikut merubah table jadi diganti pake id aja biar nip bisa diubah dan ga mempengaruhi table
    $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
    $table->unsignedBigInteger('kantor_id');
    $table->foreign('kantor_id')->references('kantor_id')->on('kantor')->onUpdate('cascade')->onDelete('restrict');
    $table->date('tanggal');
    $table->time('jam_masuk')->nullable();
    $table->time('jam_pulang')->nullable();
    $table->decimal('lat_masuk', 10, 7)->nullable();
    $table->decimal('long_masuk', 10, 7)->nullable();
    $table->float('jarak_masuk')->nullable();
    $table->enum('status', ['hadir', 'izin', 'sakit', 'hamil', 'alpha', 'lembur']);
    // 1 karyawan cuma boleh 1 absensi per hari
    $table->unique(['karyawan_id', 'tanggal']);

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
        Schema::dropIfExists('absensi');
    }
}
