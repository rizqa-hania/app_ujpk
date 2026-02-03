<?php

namespace App\Http\Controllers;

use App\MasterSubUnit;
use App\MasterUnitPln;
use Illuminate\Http\Request;

class MasterSubUnitController extends Controller
{
    public function index()
    {
        $subUnits = MasterSubUnit::with('unitPln')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('master_sub_unit.index', compact('subUnits'));
    }

    public function create()
    {
        $unitPln = MasterUnitPln::orderBy('nama_unit')->get();

        return view('master_sub_unit.create', compact('unitPln'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unitpln_id'     => 'required',
            'kode_sub'       => 'required|unique:master_sub_unit,kode_sub',
            'nama_sub_unit'  => 'required',
            'is_active'      => 'required',
        ]);

        MasterSubUnit::create($request->all());

        return redirect()
            ->route('master-sub-unit.index')
            ->with('success', 'Sub Unit berhasil ditambahkan');
    }

    public function destroy($id)
    {
        MasterSubUnit::findOrFail($id)->delete();

        return back()->with('success', 'Sub Unit berhasil dihapus');
    }
}
