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
            $table->string('nip', 30)->primary();
            $table->date('tanggal_input')->nullable();
            // ini nanti yang relasi taro di sini
           $table->unsignedBigInteger('unitpln_id');
           $table->foreign('unitpln_id')
                ->references('unitpln_id')
                ->on('master_unit_pln')
                ->onUpdate('cascade') // Kalau ID di tabel master berubah, maka semua data yang mereferensikannya ikut berubah otomatis.
                ->onDelete('restrict'); //Data master TIDAK BOLEH dihapus kalau masih dipakai.
            $table->unsignedBigInteger('jabatan_id');
            $table->foreign('jabatan_id')
                ->references('jabatan_id')
                ->on('master_jabatan')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->unsignedBigInteger('sub_id');
            $table->foreign('sub_id')
                ->references('sub_id')
                ->on('master_sub_unit')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')
                ->references('project_id')
                ->on('master_project')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->unsignedBigInteger('pendidikan_id');
            $table->foreign('pendidikan_id')
                ->references('pendidikan_id')
                ->on('master_pendidikan')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->unsignedBigInteger('tad_id');
            $table->foreign('tad_id')
                ->references('tad_id')
                ->on('master_tad')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        
            // ini nanti tambahin kerja sama klu memang harus

            // ini tuh status kerja 
            $table->date('tanggal_mulai_aktif')->nullable();
            $table->string('unit_penempatan', 100)->nullable();
            $table->enum('status_karyawan',['aktif','nonaktif'])->default('aktif');
            $table->text('keterangan')->nullable();


            //ini teh bagian identitas dirii asekk ;)
            $table->string('nama_depan',100);
            $table->string('nama_belakang',100);
            $table->string('nama_panggilan',100)->nullable();
            //data fisik
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->enum('gol_darah', ['A', 'B', 'AB', 'O'])->nullable();
            $table->string('ukuran_baju', 10)->nullable();
            $table->string('ukuran_celana', 10)->nullable();
            $table->integer('ukuran_sepatu')->nullable();
            // ini adlaah
            $table->string('tempat_lahir',100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin',['laki-laki','perempuan'])->nullable();
            $table->string('agama',50)->nullable();
            $table->string('suku_bangsa',50)->nullable();
             //keluarga
            $table->enum('status_nikah',['belum_menikah','sudah_nikah','cerai'])->nullable();
            $table->integer('jumlah_anak')->default(0);
            //alamat
            $table->text('alamat')->nullable();
            //kontak
            $table->string('no_HP_utama', 20)->nullable();
            $table->string('no_HP_cadangan', 20)->nullable();
            $table->string('email_pribadi', 100)->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('facebook', 100)->nullable();
            $table->string('foto_3x4')->nullable();
            //kontak darurat
            $table->string('nama_kontak_darurat', 100)->nullable();
            $table->string('nomor_darurat', 20)->nullable();
            $table->string('email_darurat', 100)->nullable();
            //
            // PENDIDIKAN
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
            $table->string('no_rg_bank',30)->nullable();
            $table->string('nama_bank', 50)->nullable();
            $table->string('file_buku_tabungan')->nullable();
            $table->string('no_bpjs', 30)->nullable();
            $table->string('file_bpjs')->nullable();
            $table->string('no_bpjstk', 30)->nullable(); 
            //adalah
            $table->string('file_bpjstk')->nullable();
            $table->string('no_rek_bplk', 30)->nullable();
            $table->string('file_buku_bplk')->nullable();

            //dokumen umum
            $table->string('file_surat_lamaran')->nullable();
            $table->string('file_cv')->nullable();
            $table->string('file_pakta_integritas')->nullable();
            $table->string('file_data_consist')->nullable();

            //penggalaman kerja
            $table->text('pengalaman_kerja_1')->nullable();
            $table->text('pengalaman_kerja_2')->nullable();
            $table->text('pengalaman_kerja_3')->nullable();

            //kesehatan
            $table->date('tanggal_mcu')->nullable();
            $table->string('file_hasil_mcu')->nullable();
            $table->boolean('perokok')->nullable();
            $table->text('penyakit_bawaan')->nullable();

            //SKCK dan narkoba
            $table->date('tanggal_skck')->nullable();
            $table->string('file_skck')->nullable();
            $table->date('tanggal_bnn')->nullable();
            $table->string('file_bnn')->nullable();
                    
            // driver 05
            $table->string('no_sim_a', 30)->nullable();
            $table->date('masa_berlaku_sim')->nullable();
            $table->string('file_sim')->nullable();
            $table->integer('jumlah_tilang_6_bulan')->nullable();

            // satpam 03
            $table->string('no_kta', 30)->nullable();
            $table->date('masa_berlaku_kta')->nullable();
            $table->string('file_kta')->nullable();
            $table->enum('pangkat_garda', ['pratama','madya','utama'])->nullable();
            $table->string('no_sertifikat_garda', 50)->nullable();
            $table->string('file_sertifikat_garda')->nullable();
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
