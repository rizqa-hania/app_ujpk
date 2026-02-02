<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jabatan;


class MasterJabatanController extends Controller
{
    
public function index()
{
    $jabatan = Jabatan::orderBy('nama_jabatan')->get();
    return view('master_jabatan.index', compact('jabatan'));
}

public function create()
{
    return view('master_jabatan.create');
}

public function store(Request $request)
{
    $request->validate([
        'kode_jabatan' => 'required|unique:master_jabatan,kode_jabatan',
        'nama_jabatan' => 'required'
    ]);

    Jabatan::create($request->all());

    return redirect()->route('master_jabatan.index')
        ->with('success', 'Data jabatan berhasil disimpan');
}

public function toggleStatus($id)
{
    $jabatan = Jabatan::findOrFail($id);

    $jabatan->status = $jabatan->status === 'aktif'
        ? 'n-onaktif'
        : 'aktif';

    $jabatan->save();

    return redirect()->route('master_jabatan.index')
        ->with('success', 'Status jabatan berhasil diubah');
}

// public function edit($id)
//{$jabatan = Jabatan::findOrFail($id);
//return view('master_jabatan.edit', compact('jabatan'));}

public function update(Request $request, $id)
{
    $jabatan = Jabatan::findOrFail($id);

    $request->validate([
        'kode_jabatan' => 'required|unique:master_jabatan,kode_jabatan,' . $jabatan->jabatan_id,
        'nama_jabatan' => 'required'
    ]);

    $jabatan->update($request->all());

    return redirect()->route('master_jabatan.index')
        ->with('success', 'Data jabatan berhasil diperbarui');
}

 public function destroy($id)
    {
        Jabatan::where('jabatan_id', $id)->delete();
        return Redirect()->route('master_jabatan.index');
    }

}
