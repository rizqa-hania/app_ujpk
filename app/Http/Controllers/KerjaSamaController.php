<?php

namespace App\Http\Controllers;

use App\MasterKerjaSama;
use App\MasterUnitPln;
use Illuminate\Http\Request;

class KerjaSamaController extends Controller
{
    public function create()
    {
        $unitPln = MasterUnitPln::orderBy('nama_unit')->get();
        return view('kerja_sama.create', compact('unitPln'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unitpln_id'      => 'required|exists:master_unit_pln,unitpln_id',
            'nama_kerja_sama' => 'required',
            'mitra'           => 'required',
            'jenis_kerjasama' => 'required',
        ]);

        MasterKerjaSama::create([
            'unitpln_id'      => $request->unitpln_id,
            'nama_kerja_sama' => $request->nama_kerja_sama,
            'mitra'           => $request->mitra,
            'jenis_kerjasama' => $request->jenis_kerjasama,
            'is_active'       => true,
        ]);

        return redirect()
            ->route('sub-unit.index')
            ->with('success', 'Kerja sama berhasil ditambahkan');
    }

    public function destroy($id)
    {
        MasterKerjaSama::findOrFail($id)->delete();

        return redirect()
            ->route('sub-unit.index')
            ->with('success', 'Kerja sama berhasil dihapus');
    }
}
