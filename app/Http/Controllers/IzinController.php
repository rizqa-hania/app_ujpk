<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Izin;
use Carbon\Carbon;

class IzinController extends Controller
{
    public function index(Request $request)
{
    $query = Izin::with('user');

    // Kalau user biasa → hanya lihat izin sendiri
    if (auth()->user()->role == 'user') {
        $query->where('user_id', auth()->id());
    }

    // SEARCH
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('jenis', 'like', "%{$search}%")
              ->orWhere('status', 'like', "%{$search}%")
              ->orWhere('keterangan', 'like', "%{$search}%")
              ->orWhere('tanggal_mulai', 'like', "%{$search}%")
              ->orWhere('tanggal_selesai', 'like', "%{$search}%")
              ->orWhereHas('user', function ($q2) use ($search) {
                  $q2->where('name', 'like', "%{$search}%");
              });

        });
    }

    $dataIzin = $query->orderBy('created_at', 'desc')
                      ->paginate(10);

    return view('izin.index', compact('dataIzin'));
}

    public function create()
    {
        return view('izin.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'jenis' => 'required|in:izin,cuti,sakit',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'keterangan' => 'required',
        'file_bukti' => 'nullable|mimes:jpg,png,pdf|max:2048'
    ]);

    $fileName = null;

    if($request->hasFile('file_bukti')){
        $fileName = time().'.'.$request->file('file_bukti')->extension();
        $request->file('file_bukti')->move(public_path('bukti_izin'), $fileName);
    }

    Izin::create([
        'user_id' => Auth::id(),
        'jenis' => $request->jenis, // TAMBAHAN
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
        'keterangan' => $request->keterangan,
        'file_bukti' => $fileName,
        'status' => 'pending'
    ]);

    return redirect()->route('izin.index')
        ->with('success','Pengajuan berhasil dikirim');
}

    public function edit($id)
    {
        $izin = Izin::findOrFail($id);

        if($izin->user_id != Auth::id()){
            abort(403);
        }

        return view('izin.edit', compact('izin'));
    }

    public function update(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);

        if($izin->user_id != Auth::id()){
            abort(403);
        }

        $izin->update([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('izin.index')
            ->with('success','Izin berhasil diperbarui');
    }

    public function destroy($id)
    {
        $izin = Izin::findOrFail($id);

        if($izin->user_id != Auth::id()){
            abort(403);
        }

        $izin->delete();

        return back()->with('success','Izin berhasil dihapus');
    }
     public function approve($id)
{
    if (Auth::user()->role != 'admin') {
        abort(403);
    }

    $izin = Izin::findOrFail($id);
    $izin->status = 'disetujui';
    $izin->save();

    return back()->with('success','Izin disetujui');
}

public function reject($id)
{
    if (Auth::user()->role != 'admin') {
        abort(403);
    }

    $izin = Izin::findOrFail($id);
    $izin->status = 'ditolak';
    $izin->save();

    return back()->with('success','Izin ditolak');
}
public function __construct()
{
    $this->middleware('auth');
}
}