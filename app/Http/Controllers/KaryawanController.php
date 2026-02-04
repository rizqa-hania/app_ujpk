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
            '' => MasterSubUnit::all(),
            '' =>MasterKerjaSama::all(),



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
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'agama' => 'nullable|string',
            'suku_bangsa' => 'nullabel|string',
            'alamat' => 'nullabel|string',
            'status_nikah' => 'nullable|in:belum_nikah,sudah_nikah,cerai',
            'jumlah_anak' => 'nullable|integer|min:0',
            'no_HP_utama' => 'nullable|string|max:15',
            'no_HP_cadangan' => 'nullable|string|max:15',
            'email_pribadi' => 'nullable|email',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
            'nomor_darurat' => 'nullable|string|max:15',
            'email_darurat' => 'nullable|email',
            'tinggi_badan'  => 'nullable|integer',
            'berat_badan'   => 'nullable|integer',
            'gol_darah' => 'nullable|in:A,B,AB,O',
            'ukuran_baju' => 'nullable',
            'ukuran_celana' => 'nullable',
            'ukuran_sepatu' => 'nullable',
            'nama_perguruan' => 'nullable',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'no_ktp' => 'nullable|string',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'no_kk' => 'nullable|string',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'no_npwp' => 'nullable|string',
            'file_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'no_bpjs' => 'nullable|string',
            'file_bpjs' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'no_bpjstk' => 'nullable|string',
            'file_bpjstk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', 
            'no_rek_bpk' => 'nullable|string',
            'bank' => 'nullable|string',
            'file_buku_tabungan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'jenis_dokumen' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_path' => 'nullable|string',
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
