<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use Illuminate\Http\Request;

class LemburController extends Controller
{
    public function index()
    {
        $data = Lembur::orderBy('created_at', 'desc')->get();
        return view('lembur.index', compact('data'));
    }

    public function create()
    {
        return view('lembur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        Lembur::create($request->all());

        return redirect()->route('lembur.index')->with('success', 'Pengajuan lembur berhasil dibuat');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan' => 'nullable'
        ]);

        $lembur = Lembur::findOrFail($id);
        $lembur->status = $request->status;
        $lembur->keterangan = $request->keterangan;
        $lembur->save();

        return redirect()->back()->with('success', 'Status lembur berhasil diperbarui');
    }
}
