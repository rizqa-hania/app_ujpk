<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_project', function (Blueprint $table) {
            $table->bigIncrements('project_id');
            //nanti disini tambahin karyawan soalnya relasi ke karyawan juga, sebenernya sih 
            //ga juga ya kan kalau mereka milih jabatan, unit pln->sub unit itu otomatis nanti dia
            //tinggal milih project terus pas itu nanti di dashboard karyawan dah tergolong klu dia dapet
            // project ini kan yaa, nah nanti ketauan tuh siapa aja yang dibagian itu
            $table->foreignId('sub_id')->references('sub_id')->on('master_sub_unit');
            $table->string('kode_project')->unique();
            $table->string('nama_project');
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
        Schema::dropIfExists('master_project');
    }
}
