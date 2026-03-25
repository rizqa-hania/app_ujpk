<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Izin;
use App\Absensi;
use App\Mail\PengajuanIzinMail;
use Carbon\Carbon;
use Exception;

class IzinController extends Controller
{
    public function index(Request $request)
    {
        $query = Izin::with('user');

        // Jika bukan admin, hanya lihat data sendiri
        if (Auth::user()->role != 'admin') {
            $query->where('user_id', Auth::id());
        }

        // Fitur Pencarian
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('jenis', 'like', '%' . $request->search . '%')
                  ->orWhere('status', 'like', '%' . $request->search . '%')
                  ->orWhere('tanggal_mulai', 'like', '%' . $request->search . '%');
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

        // Simpan file ke storage public
        $filePath = null;
        if ($request->hasFile('file_bukti')) {
            $filePath = $request->file('file_bukti')->store('bukti_izin', 'public');
        }

        $izin = Izin::create([
            'user_id' => Auth::id(),
            'jenis' => $request->jenis,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'file_bukti' => $filePath,
            'status' => 'pending',
        ]);

        // Kirim email ke semua admin
        try {
            $admins = User::where('role', 'admin')->pluck('email');
            $dataMail = [
                'nama' => Auth::user()->name,
                'tipe' => 'Izin',
                'jenis' => $izin->jenis,
                'mulai' => $izin->tanggal_mulai,
                'selesai' => $izin->tanggal_selesai,
                'keterangan' => $izin->keterangan,
                'status' => 'pengajuan'
            ];

            foreach ($admins as $email) {
                Mail::send('mail', $dataMail, function ($message) use ($email) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                            ->to($email)
                            ->subject('Pengajuan Izin Baru');
                });
            }
        } catch (Exception $e) {
            // Email gagal tidak membatalkan simpan data
        }

        return redirect()->route('izin.index')->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    public function edit($id)
    {
        $izin = Izin::findOrFail($id);
        if ($izin->user_id != Auth::id()) abort(403);
        
        return view('izin.edit', compact('izin'));
    }

    public function update(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);
        if ($izin->user_id != Auth::id()) abort(403);

        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string'
        ]);

        $izin->update([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('izin.index')->with('success', 'Izin berhasil diperbarui');
    }

    public function destroy($id)
    {
        $izin = Izin::findOrFail($id);
        if ($izin->user_id != Auth::id()) abort(403);
        
        $izin->delete();
        return back()->with('success', 'Izin berhasil dihapus');
    }

    public function approve($id)
    {
        if (Auth::user()->role != 'admin') abort(403);

        $izin = Izin::with('user')->findOrFail($id);
        $izin->update(['status' => 'disetujui']);

        // Kirim email ke User
        if ($izin->user && $izin->user->email) {
            try {
                Mail::send('mail', [
                    'nama' => $izin->user->name,
                    'tipe' => 'Izin',
                    'jenis' => $izin->jenis,
                    'mulai' => $izin->tanggal_mulai,
                    'selesai' => $izin->tanggal_selesai,
                    'keterangan' => $izin->keterangan,
                    'status' => 'disetujui'
                ], function ($message) use ($izin) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                            ->to($izin->user->email)
                            ->subject('Izin Disetujui');
                });
            } catch (Exception $e) {}
        }

        // Generate absensi otomatis
        $start = Carbon::parse($izin->tanggal_mulai);
        $end   = Carbon::parse($izin->tanggal_selesai);
        
        while ($start->lte($end)) {
            Absensi::updateOrCreate(
                ['user_id' => $izin->user_id, 'tanggal' => $start->toDateString()],
                [
                    'jam_masuk' => null, 
                    'jam_pulang' => null, 
                    'status_masuk' => null, 
                    'status_pulang' => null, 
                    'status_final' => $izin->jenis
                ]
            );
            $start->addDay();
        }

        return back()->with('success', 'Izin disetujui dan otomatis masuk absensi.');
    }

    public function reject($id)
    {
        if (Auth::user()->role != 'admin') abort(403);

        $izin = Izin::with('user')->findOrFail($id);
        $izin->update(['status' => 'ditolak']);

        if ($izin->user && $izin->user->email) {
            try {
                Mail::send('mail', [
                    'nama' => $izin->user->name,
                    'tipe' => 'Izin',
                    'jenis' => $izin->jenis,
                    'mulai' => $izin->tanggal_mulai,
                    'selesai' => $izin->tanggal_selesai,
                    'keterangan' => $izin->keterangan,
                    'status' => 'ditolak'
                ], function ($message) use ($izin) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                            ->to($izin->user->email)
                            ->subject('Izin Ditolak');
                });
            } catch (Exception $e) {}
        }

        return back()->with('success', 'Izin ditolak.');
    }
}