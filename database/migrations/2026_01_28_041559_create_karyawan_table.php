<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->bigIncrements('nip',30)->unique();
            // ini nanti yang relasi taro di sini
            $table->foreignId('unitpln_id')->references('unitpln_id')->on('master_unit_pln');
            $table->foreignId('jabatan_id')->references('jabatan_id')->on('master_jabatan');
            $table->foreignId('sub_id')->references('sub_id')->on('master_sub_unit');
            $table->foreignId('project_id')->references('project_id')->on('master_project');
            $table->foreingId('pendidikan_id')->references('pendidikan_id')->on('master_pendidikan');
            $table->foreignId('tad_id')->references('tad_id')->on('master_sub_unit');
            //ini teh bagian identitas dirii asekk ;)
            $table->string('nama_depan',100);
            $table->string('nama_belakang',100);
            $table->string('nama_panggilan',100)->nullable();
            $table->enum('status',['aktif','nonaktif'])->nullable();
            //
            $table->string('tempat_lahir',100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin',['laki-laki','perempuan'])->nullable();
            $table->string('agama',50)->nullable();
            $table->string('suku_bangsa',50)->nullable();
            $table->text('alamat')->nullable();
            //keluarga
            $table->enum('status_nikah',['belum menikah','sudah menikah','cerai'])->nullable();
            $table->integer('jumlah_anak')->default(0);
            //kontak
            $table->string('no_HP_utama', 20)->nullable();
            $table->string('no_HP_cadangan', 20)->nullable();
            $table->string('email_pribadi', 100)->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('facebook', 100)->nullable();
            //kontak darurat
            $table->string('nomor_darurat', 20)->nullable();
            $table->string('email_darurat', 100)->nullable();
            //data fisik
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->enum('gol_darah', ['A', 'B', 'AB', 'O'])->nullable();
            $table->string('ukuran_baju', 10)->nullable();
            $table->string('ukuran_celana', 10)->nullable();
            $table->integer('ukuran_sepatu')->nullable();
            // PENDIDIKAN
            $table->string('kode_pendidikan_terakhir', 10)->nullable();
            $table->string('nama_perguruan')->nullable();
            $table->string('file_ijazah')->nullable();
            // IDENTITAS RESMI
            $table->string('no_ktp', 30)->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('no_kk', 30)->nullable();
            $table->string('file_kk')->nullable();
            $table->string('no_npwp', 30)->nullable();
            $table->string('file_npwp')->nullable();
            // BPJS & KEUANGAN
            $table->string('no_bpjs', 30)->nullable();
   
            $table->string('file_bpjs')->nullable();
            $table->string('no_bpjstk', 30)->nullable();
            $table->string('no_rek_bpk', 30)->nullable();
            $table->string('bank', 50)->nullable();
            $table->string('file_buku_tabungan')->nullable();
            // DOKUMEN
            $table->string('jenis_dokumen', 50)->nullable();
            $table->string('file_dokumen')->nullable();
            $table->string('file_path')->nullable();
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
        Schema::dropIfExists('karyawan');
    }
}
