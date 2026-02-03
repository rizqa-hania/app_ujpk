<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterUnitPln;

class MasterUnitPlnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pln = MasterUnitPln::orderBy('nama_unit')->get();
        return view('master_unit_pln.index', compact('pln'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master_unit_pln.create');
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
        'kode_unit' => 'required|unique:master_unit_pln,kode_unit',
        'nama_unit' => 'required'
        ]);

        MasterUnitPln::create($request->all());

        return redirect()->route('master_unit_pln.index')
        ->with('success', 'UNit berhasil disimpan');
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
        MasterUnitPln::where('unitpln_id', $id)->delete();
        return Redirect()->route('master_unit_pln.index');
    }
}

