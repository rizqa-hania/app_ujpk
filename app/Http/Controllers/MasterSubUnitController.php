<?php

namespace App\Http\Controllers;

use App\MasterSubUnit;
use App\MasterKerjaSama;
use App\MasterUnitPln;
use Illuminate\Http\Request;

class MasterSubUnitController extends Controller
{
    public function index()
    {
        $subUnit   = MasterSubUnit::with('unitpln')->get();
        $kerjaSama = MasterKerjaSama::with('unitpln')->get();

        return view('master_sub_unit.index', compact('subUnit', 'kerjaSama'));
    }

    public function create()
    {
        $unitPln = MasterUnitPln::orderBy('nama_unit')->get();
        return view('master_sub_unit.create', compact('unitPln'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unitpln_id'     => 'required|exists:master_unit_pln,unitpln_id',
            'kode_sub'       => 'required|unique:master_sub_unit,kode_sub',
            'nama_sub_unit'  => 'required',
        ]);

        MasterSubUnit::create([
            'sub_id'    => $request->sub_id,
            'kode_sub'      => $request->kode_sub,
            'nama_sub_unit' => $request->nama_sub_unit,
            'is_active'     => true,
        ]);

        return redirect()->route('sub-unit.index')->with('success', 'Sub Unit berhasil ditambahkan');
    }

    public function destroy($id)
    {
        MasterSubUnit::findOrFail($id)->delete();

        return redirect()->route('sub-unit.index')->with('success', 'Sub Unit berhasil dihapus');
    }
}
