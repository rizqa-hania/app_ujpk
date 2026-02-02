<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterPendidikan;

class MasterPendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pendidikan = MasterPendidikan::orderBy('nama_pendidikan')->get();
        return view('master_pendidikan.index', compact('pendidikan'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master_pendidikan.create');
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
        'kode_pendidikan' => 'required|unique:master_pendidikan,kode_pendidikan',
        'nama_pendidikan' => 'required'
        ]);

        MasterPendidikan::create($request->all());

        return redirect()->route('master_pendidikan.index')
        ->with('success','pendidikan berhasil disimpan');
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
        MasterPendidikan::where('pendidikan_id', $id)->delete();
        return Redirect()->route('master_pendidikan.index');
    }
}
