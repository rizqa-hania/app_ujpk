<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterJabatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_jabatan', function (Blueprint $table) {
            $table->bigIncrements('jabatan_id');
            $table->string('kode_jabatan')->unique();
            $table->string('nama_jabatan');
            $table->enum('status',['aktif','nonaktif'])->default('aktif');
            $table->boolean('is_satpam')->default(false);
            $table->boolean('is_driver')->default(false);

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
        Schema::dropIfExists('master_jabatan');
    }
}
