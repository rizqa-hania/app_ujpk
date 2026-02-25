<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ModifyKaryawanTableMakeNamaLengkapNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE karyawan MODIFY nama_lengkap VARCHAR(100) NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE karyawan MODIFY nama_lengkap VARCHAR(100) NOT NULL');
    }
}
