<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penggajian;

class PenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penggajian = Penggajian::all();
        return view('penggajian.index', compact('penggajian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penggajian.create');
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
            'periode_bulan' => 'required|integer',
            'periode_tahun' => 'required|integer',
            'status' => 'required|string',
        ]);

        Penggajian::create([
            'periode_bulan' => $request->periode_bulan,
            'periode_tahun' => $request->periode_tahun,
            'status' => $request->status
        ]);

        return redirect()->route('penggajian.index');
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
        $dataeditpenggajian = Penggajian::find($id);
        return view('penggajian.edit', compact('dataeditpenggajian'));
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
            'periode_bulan' => 'required|integer',
            'periode_tahun' => 'required|integer',
            'status' => 'required|string',
        ]);

        $updatedata = Penggajian::findOrFail($id);

        $updatedata->update([
            'periode_bulan' => $request->periode_bulan,
            'periode_tahun' => $request->periode_tahun,
            'status' => $request->status,
        ]);

        return redirect()->route('penggajian.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Penggajian::where('penggajian_id', $id)->delete();
        return redirect()->route('penggajian.index');
    }
}
