<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $primaryKey = 'nip';

    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'nama_panggilan',
        'status',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'suku_bangsa',
        'alamat',
        'status_nikah',
        'jumlah_anak',
        'no_hp_utama',
        'no_hp_cadangan',
        'email_pribadi',
        'instagram',
        'facebook',
        'nomor_darurat',
        'email_darurat',
        'tinggi_badan',
        'berat_badan',
        'gol_darah',
        'ukuran_baju',
        'ukuran_celana',
        'ukuran_sepatu',
        'nama_perguruan',
        'file_ijazah',
        'no_ktp',
        'file_ktp',
        'no_kk',
        'file_kk',
        'no_npwp',
        'file_npwp',
        'no_bpjs',
        'file_bpjs',
        'no_bpjstk',
        'file_bpjstk',
        'non_rek_bpk',
        'bank',
        'file_buku_tabungan',
        'jenis_dokumen',
        'file_dokumen',
        'file_path',

    ];
}
