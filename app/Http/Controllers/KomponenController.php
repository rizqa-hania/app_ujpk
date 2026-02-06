<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Komponen;

class KomponenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $komponen = Komponen::all();
        return view('komponen.index', compact('komponen'));
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('komponen.create');
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
            'kode'                  => 'required|string',
            'komponen'              => 'required|string|max:255|unique:komponen',
            'tipe'                  => 'required',
            'tipe_penghitungan'     => 'required',
            'nilai'                 => 'required|numeric',
        ]);

        Komponen::create([
            'kode'              => $request->kode,
            'komponen'              => $request->komponen,
            'tipe'              => $request->tipe,
            'tipe_penghitungan' => $request->tipe_penghitungan,
            'nilai'             => $request->nilai
        ]);

        return redirect()->route('komponen.index');
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
    public function edit($kode)
    {
        $komponen = Komponen::find($kode);
        return view('komponen.edit', compact('komponen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kode)
    {
        $request->validate([
            'kode'                  => 'required|string|unique:komponen,kode,' . $kode . ',kode',
            'komponen'              => 'required|string|max:255',
            'tipe'                  => 'required',
            'tipe_penghitungan'     => 'required',
            'nilai'                 => 'required|numeric',
        ]);

        $updatedata = Komponen::findOrFail($kode);

        $updatedata->update([
            'kode'                  => $request->kode,
            'komponen'              => $request->komponen,
            'tipe'                  => $request->tipe,
            'tipe_penghitungan'     => $request->tipe_penghitungan,
            'nilai'                 => $request->nilai
        ]);

        return redirect()->route('komponen.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode)
    {
        Komponen::where('kode', $kode)->delete();
        return redirect()->route('komponen.index');
    }

    public function aktifkan($kode)
    {
        Komponen::where('kode', $kode)->update(['status' => 1]);
        return redirect()->route('komponen.index'); 
    }

    public function nonaktifkan($kode)
    {
        Komponen::where('kode', $kode)->update(['status' => 0]);
        return redirect()->route('komponen.index');
    }
}
