<?php

namespace App\Http\Controllers;

use App\MasterKerjaSama;
use App\MasterUnitPln;
use Illuminate\Http\Request;

class MasterKerjaSamaController extends Controller
{
    public function index()
    {
        $data = MasterKerjaSama::with('unitPln')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('master_kerja_sama.index', compact('data'));
    }

    public function create()
    {
        $unitPln = MasterUnitPln::orderBy('nama_unit')->get();

        return view('master_kerja_sama.create', compact('unitPln'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unitpln_id'       => 'required',
            'nama_kerja_sama'  => 'required',
            'mitra'            => 'required',
            'jenis_kerjasama'  => 'required',
            'is_active'        => 'required',
        ]);

        MasterKerjaSama::create($request->all());

        return redirect()
            ->route('master-kerja-sama.index')
            ->with('success', 'Data Kerja Sama berhasil ditambahkan');
    }

    public function destroy($id)
    {
        MasterKerjaSama::findOrFail($id)->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
