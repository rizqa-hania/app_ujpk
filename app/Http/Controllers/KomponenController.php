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
            'name'              => 'required|string|max:255|unique:komponen',
            'tipe'              => 'required',
            'tipe_penghitungan' => 'required',
            'nilai'             => 'required|numeric',
        ]);

        Komponen::create([
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
            'name'              => 'required|string|max:255|unique:komponen,name,' . $id . ',komponen_id',
            'tipe'              => 'required',
            'tipe_penghitungan' => 'required',
            'nilai'             => 'required|numeric',
        ]);

        $updatedata = Komponen::findOrFail($id);

        $updatedata->update([
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
        Komponen::where('komponen_id', $id)->delete();
        return redirect()->route('komponen.index');
    }
}
