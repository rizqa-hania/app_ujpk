<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Izin;
use App\Absensi;
use Carbon\Carbon;

class IzinController extends Controller
{
    public function index(Request $request)
{
    if(auth()->user()->role == 'admin'){
        $query = Izin::with('user');
    } else {
        $query = Izin::where('user_id', auth()->id());
    }

    if($request->search){
        $query->where(function($q) use ($request){
            $q->where('jenis','like','%'.$request->search.'%')
              ->orWhere('status','like','%'.$request->search.'%')
              ->orWhere('tanggal_mulai','like','%'.$request->search.'%');
        });
    }

    $dataIzin = $query->latest()->paginate(10);

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
        'keterangan' => 'required|string',
        'file_bukti' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048'
    ]);

    $filePath = null;

    if ($request->hasFile('file_bukti')) {
        $filePath = $request->file('file_bukti')->store('bukti_izin', 'public');
    }

    $izin = Izin::create([
        'user_id' => auth()->id(),
        'jenis' => $request->jenis,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
        'keterangan' => $request->keterangan,
        'file_bukti' => $filePath,
        'status' => 'pending',
    ]);

    // ambil semua admin
    $admins = User::where('role','admin')->get();

    foreach($admins as $admin){
        Mail::raw(
            "Ada pengajuan izin baru dari ".auth()->user()->name.
            "\nJenis: ".$izin->jenis.
            "\nTanggal: ".$izin->tanggal_mulai." sampai ".$izin->tanggal_selesai.
            "\nKeterangan: ".$izin->keterangan,
            function ($message) use ($admin) {
                $message->to($admin->email)
                        ->subject('Pengajuan Izin Baru');
            }
        );
    }

    return redirect()->route('izin.index')
        ->with('success','Pengajuan izin berhasil dikirim.');
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
    if(auth()->user()->role != 'admin'){
        abort(403);
    }

    $izin = Izin::findOrFail($id);

    $izin->update([
        'status' => 'disetujui'
    ]);

    $start = Carbon::parse($izin->tanggal_mulai);
    $end   = Carbon::parse($izin->tanggal_selesai);

    while ($start->lte($end)) {

        Absensi::firstOrCreate(
            [
                'user_id' => $izin->user_id,
                'tanggal' => $start->toDateString()
            ],
            [
                'jam_masuk'    => null,
                'jam_pulang'   => null,
                'status_masuk' => null,
                'status_pulang'=> null,
                'status_final' => $izin->jenis
            ]
        );

        $start->addDay();
    }

    return back()->with('success','Izin disetujui dan otomatis masuk absensi.');
}


public function reject($id)
{
    if(auth()->user()->role != 'admin'){
        abort(403);
    }

    $izin = Izin::findOrFail($id);

    $izin->update([
        'status' => 'ditolak'
    ]);

    return back()->with('success','Izin ditolak.');
}
}