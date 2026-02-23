<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detail;
use App\Penggajian;
use App\Karyawan;
use App\Komponen;
use App\DetailKomponen;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $detail = Detail::with('karyawan')->where('penggajian_id', $id)->get();

        return view('detail.index', compact('penggajian', 'detail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $karyawan = Karyawan::all();
        $komponen = Komponen::all();

        return view('detail.create', compact('penggajian', 'karyawan', 'komponen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $detail_id)
    {
        $request->validate([
            'nama'                  => 'required|string',
            'nip'              => 'required|string|max:255|unique:karyawan',
            'tipe'                  => 'required',
            'nilai'                 => 'required|numeric',
        ]);

        $detail = Detail::findOrFail($detail_id);

        DetailKomponen::create([
            'nama'              => $request->nama,
            'nip'              => $request->nip,
            'tipe'              => $request->tipe,
            'nilai'             => $request->nilai
        ]);

        return redirect()->route('detail.index', $request->penggajian_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($detail_id)
    {
        $detail = Detail::with(['karyawan.jabatan', 'detailKomponen.komponen', 'penggajian'])->findOrFail($detail_id);
        
        return view('detail.slip_gaji', compact('detail'));
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

    public function tambahkomponen()
    {
        //
    }
}
