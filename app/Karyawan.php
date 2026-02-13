<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



class Karyawan extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey = 'karyawan_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'unitpln_id',
        'jabatan_id',
        'project_id',
        'sub_id',
        'tad_id',
        'pendidikan_id',
        'tanggal_input',
        'tanggal_mulai_aktif',
        'status_karyawan',
        'keterangan',
        'nama_depan',
        'nama_belakang',
        'nama_panggilan',
        //ini itu
        'tinggi_badan',
        'berat_badan',
        'gol_darah',
        'ukuran_baju',
        'ukuran_celana',
        'ukuran_sepatu',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        
        'suku_bangsa',

        'status_nikah',
        'jumlah_anak',
        'alamat',
        'no_HP_utama',
        'no_HP_cadangan',
        'email_pribadi',
        'instagram',
        'facebook',
        'foto_3x4',
        'nama_kontak_darurat',
        'nomor_darurat',
        'email_darurat',

        'nama_perguruan',
        'file_ijazah',
        'no_ktp',
        'file_ktp',
        'no_kk',
        'file_kk',
        'no_npwp',
        'file_npwp',
        'no_rg_bank',
        'nama_bank',
        'file_buku_tabungan',
        'no_bpjs',
        'file_bpjs',
        'no_bpjstk',
        'file_bpjstk',
        'no_rek_bplk',
        'file_buku_bplk',
        'file_surat_lamaran',
        'file_cv',
        'file_pakta_integritas',
        'file_data_consist',
        'pengalaman_kerja_1',
        'pengalaman_kerja_2',
        'pengalaman_kerja_3',
        'tanggal_mcu',
        'file_hasil_mcu',
        'perokok',
        'penyakit_bawaan',
        'tanggal_skck',
        'file_skck',
        'tanggal_bnn',
        'file_bnn',
        'no_sim_a',
        'masa_berlaku_sim',
        'file_sim',
        'jumlah_tilang_6_bulan',
        'no_kta',
        'masa_berlaku_kta',
        'file_kta',
        'pangkat_garda',
        'no_sertifikat_garda',
        'file_sertifikat_garda',
    ];

    public function jabatan()
    {
            return $this->belongsTo(MasterJabatan::class, 'jabatan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

        public function detail()
    {
        return $this->hasMany(Detail::class, 'nip');
    }

    }
