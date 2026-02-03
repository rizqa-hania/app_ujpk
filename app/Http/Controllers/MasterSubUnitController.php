<?php

namespace App\Http\Controllers;

use App\MasterSubUnit;
use App\MasterUnitPln;
use Illuminate\Http\Request;

class MasterSubUnitController extends Controller
{
    public function index()
    {
        $data = MasterSubUnit::with('unitPln')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('master_sub_unit.index', compact('data'));
    }

    public function create()
    {
        $unitPln = MasterUnitPln::orderBy('nama_unit')->get();
        return view('master_sub_unit.create', compact('unitPln'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unitpln_id'       => 'required|exists:master_unit_pln,unitpln_id',
            'kode_sub'         => 'required|unique:master_sub_unit,kode_sub',
            'nama_sub'         => 'required',
            'nama_mitra'       => 'required',
            'jenis_kerjasama'  => 'required',
            'tanggal_mulai'    => 'nullable|date',
            'tanggal_selesai'  => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        MasterSubUnit::create($request->all());

        return redirect()
            ->route('master-sub-unit.index')
            ->with('success', 'Data kerja sama berhasil ditambahkan');
    }

    public function destroy($id)
    {
        MasterSubUnit::findOrFail($id)->delete();

        return redirect()
            ->route('master-sub-unit.index')
            ->with('success', 'Data kerja sama berhasil dihapus');
    }
}

