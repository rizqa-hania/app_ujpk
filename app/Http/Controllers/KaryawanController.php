<?php

namespace App\Http\Controllers;

use App\Karyawan;
use Illuminate\Http\Request;
use App\Jabatan;
use App\MasterUnitPln;
use App\MasterSubUnit;
use App\MasterProject;
use App\MasterPendidikan;
use App\MasterTad;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $karyawan = karyawan::all();
        return view('karyawan.index', compact('karyawan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('karyawan.create',[
            'jabatan' => Jabatan::all(),
            'pln' => MasterUnitPln::all(),
            'pendidikan' => MasterPendidikan::all(),
            'project' => MasterProject::all(),
            'tad' => MasterTad::all(),
            //tambahin sub unit dan kerjasama

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' =>'required|string|max:100',
            'nama_panggilan' => 'required|string|max:100',
            'tempat_lahir' => '',
            'tanggal_lahir' => '',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'agama' => '',
            'suku_bangsa' => '',
            'alamat' => '',
            'status_nikah' => 'nullable|in:belum_nikah, sudah_nikah,cerai',
            'jumlah_anak' => '',
            'no_HP_utama' => '',
            'no_HP_cadangan' => '',
            'email_pribadi' => '',
            'instagram' => '',
            'facebook' => '',
            'nomor_darurat' => '',
            'email_darurat' => '',
            'tinggi_badan'  => '',
            'berat_badan'   => '',
            'gol_darah' => '',
            'ukuran_baju' => '',
            'ukuran_celana' => '',
            'ukuran_sepatu' => '',
            'nama_perguruan' => '',
            'file_ijazah' => '',
            'no_ktp' => '',
            'file_ktp' => '',
            'no_kk' => '',
            'file_kk' => '',
            'no_npwp' => '',
            'file_npwp' => '',
            'no_bpjs' => '',
            'file_bpjs' => '',
            'no_bpjstk' => '',
            'file_bpjstk' => '', // ini ada kalau udah di migrate
            'no_rek_bpk' => '',
            'bank' => '',
            'file_buku_tabungan' => '',
            'jenis_dokumen' => '',
            'file_dokumen' => '',
            'file_path' => '',
            // ini nanti masih ada yang harus ditambahin 
            // sekali dijalanin eror nih pasti yep aman that simple(👉ﾟヮﾟ)👉
            

            
            // tampilan nya harus keren, bikin orang ga bosen dan harus sesuai... oke klu gitu biru,putih, kuning
            



        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
