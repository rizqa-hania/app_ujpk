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

    /**
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
            'kode'              => 'required|string',
            'name'              => 'required|string|max:255|unique:komponen',
            'tipe'              => 'required',
            'tipe_penghitungan' => 'required',
            'nilai'             => 'required|numeric',
        ]);

        Komponen::create([
            'kode'              => $request->kode,
            'name'              => $request->name,
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
    public function edit($id)
    {
        $komponen = Komponen::find($id);
        return view('komponen.edit', compact('komponen'));
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
        $request->validate([
            'kode'              => 'required|string|unique:komponen,kode,' . $id . ',kode',
            'name'              => 'required|string|max:255',
            'tipe'              => 'required',
            'tipe_penghitungan' => 'required',
            'nilai'             => 'required|numeric',
        ]);

        $updatedata = Komponen::findOrFail($id);

        $updatedata->update([
            'kode'              => $request->kode,
            'name'              => $request->name,
            'tipe'              => $request->tipe,
            'tipe_penghitungan' => $request->tipe_penghitungan,
            'nilai'             => $request->nilai
        ]);

        return redirect()->route('komponen.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     
    }

    public function aktifkan($id)
    {
        Komponen::where('kode', $id)->update(['is_active' => 1]);
        return redirect()->route('komponen.index'); 
    }

    public function nonaktifkan($id)
    {
        Komponen::where('kode', $id)->update(['is_active' => 0]);
        return redirect()->route('komponen.index');
    }
}
