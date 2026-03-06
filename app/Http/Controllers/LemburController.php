<?php

namespace App\Http\Controllers;

use App\Lembur;
use App\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LemburController extends Controller
{
    public function index()
{
    if (Auth::user()->role == 'admin') {
        $data = Lembur::orderBy('created_at','desc')->get();
    } else {
        $data = Lembur::where('karyawan_id', Auth::user()->karyawan_id)
                ->orderBy('created_at','desc')
                ->get();
    }

    return view('lembur.index', compact('data'));
}
    public function create()
    {
        return view('lembur.create');
    }
    
public function store(Request $request)
{
    $request->validate([
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        'keterangan' => 'nullable|string'
    ]);

    $user = Auth::user();

    // pastikan user punya relasi karyawan
    $karyawan = Karyawan::where('nip', $user->nip)->first();

    if (!$karyawan) {
        return back()->withErrors([
            'error' => 'Data karyawan tidak ditemukan'
        ]);
    }

    Lembur::create([
        'nip' => $karyawan->nip,
        'karyawan_id' => $karyawan->id,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
        'jam_mulai' => $request->jam_mulai,
        'jam_selesai' => $request->jam_selesai,
        'keterangan' => $request->keterangan,
        'status' => 'pending'
    ]);

    return redirect()->route('lembur.index')
        ->with('success', 'Pengajuan lembur berhasil dibuat');
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
