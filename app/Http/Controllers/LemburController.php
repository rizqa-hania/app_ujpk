<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Lembur;
use App\Karyawan;
use App\User;
use App\Mail\PengajuanLemburMail;
use Exception;

class LemburController extends Controller
{
    public function index()
    {
        // Logika pemisahan tampilan Admin dan Karyawan
        if (Auth::user()->role == 'admin') {
            $data = Lembur::with('karyawan.user')->latest()->get();
        } else {
            $data = Lembur::whereHas('karyawan', function($q) {
                $q->where('user_id', Auth::id());
            })->latest()->get();
        }

        return view('lembur.index', compact('data'));
    }

    public function create()
    {
        return view('lembur.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Termasuk validasi tanggal)
        $request->validate([
            'nip' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'keterangan' => 'nullable|string'
        ]);

        // 2. Cari data Karyawan berdasarkan NIP
        $karyawan = Karyawan::where('nip', $request->nip)->first();
        if (!$karyawan) {
            return back()->withInput()->withErrors(['nip' => 'NIP karyawan tidak ditemukan di sistem.']);
        }

        // 3. Cek duplikat pengajuan agar tidak double input
        $exists = Lembur::where('karyawan_id', $karyawan->id)
                        ->where('tanggal_mulai', $request->tanggal_mulai)
                        ->where('jam_mulai', $request->jam_mulai)
                        ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['error' => 'Lembur pada tanggal dan jam tersebut sudah pernah diajukan.']);
        }

        // 4. Simpan ke Database
        $lembur = Lembur::create([
            'nip' => $karyawan->nip,
            'karyawan_id' => $karyawan->id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'keterangan' => $request->keterangan,
            'status' => 'pending'
        ]);

        // 5. Kirim Email ke Semua Admin
        try {
            $admins = User::where('role', 'admin')->get();
            $dataEmail = [
                'nama' => Auth::user()->name,
                'tipe' => 'Lembur',
                'mulai' => $lembur->tanggal_mulai,
                'selesai' => $lembur->tanggal_selesai,
                'jam_mulai' => $lembur->jam_mulai,
                'jam_selesai' => $lembur->jam_selesai,
                'keterangan' => $lembur->keterangan,
                'status' => 'pengajuan'
            ];

            foreach ($admins as $admin) {
                Mail::send('mail', $dataEmail, function($message) use ($admin) {
                    $message->to($admin->email)
                            ->subject('Pengajuan Lembur Baru - ' . Auth::user()->name);
                });
            }
        } catch (Exception $e) {
            // Jika email gagal, tetap lanjut tapi beri notifikasi
            return redirect()->route('lembur.index')->with('success', 'Pengajuan berhasil, namun gagal mengirim notifikasi email admin. Error: ' . $e->getMessage());
        }

        return redirect()->route('lembur.index')->with('success', 'Pengajuan lembur berhasil dikirim dan dinotifikasi via email ke Admin!');
    }

    public function approve($id)
    {
        if (Auth::user()->role != 'admin') abort(403);

        $lembur = Lembur::with('karyawan.user')->findOrFail($id);
        $lembur->update(['status' => 'disetujui']);

        // Kirim email balik ke Karyawan
        try {
            if ($lembur->karyawan && $lembur->karyawan->user) {
                $user = $lembur->karyawan->user;
                $dataEmail = [
                    'nama' => $user->name,
                    'tipe' => 'Lembur',
                    'mulai' => $lembur->tanggal_mulai,
                    'selesai' => $lembur->tanggal_selesai,
                    'jam_mulai' => $lembur->jam_mulai,
                    'jam_selesai' => $lembur->jam_selesai,
                    'keterangan' => $lembur->keterangan,
                    'status' => 'disetujui'
                ];

                Mail::send('mail', $dataEmail, function($message) use ($user) {
                    $message->to($user->email)->subject('Update Status: Lembur Disetujui');
                });
            }
        } catch (Exception $e) {
            return back()->with('success', 'Lembur disetujui (Catatan: Email gagal terkirim ke karyawan. Error: ' . $e->getMessage() . ')');
        }

        return back()->with('success', 'Lembur berhasil disetujui dan karyawan telah dinotifikasi via email.');
    }

    public function reject($id)
    {
        if (Auth::user()->role != 'admin') abort(403);

        $lembur = Lembur::with('karyawan.user')->findOrFail($id);
        $lembur->update(['status' => 'ditolak']);

        // Kirim email balik ke Karyawan
        try {
            if ($lembur->karyawan && $lembur->karyawan->user) {
                $user = $lembur->karyawan->user;
                $dataEmail = [
                    'nama' => $user->name,
                    'tipe' => 'Lembur',
                    'mulai' => $lembur->tanggal_mulai,
                    'selesai' => $lembur->tanggal_selesai,
                    'jam_mulai' => $lembur->jam_mulai,
                    'jam_selesai' => $lembur->jam_selesai,
                    'keterangan' => $lembur->keterangan,
                    'status' => 'ditolak'
                ];

                Mail::send('mail', $dataEmail, function($message) use ($user) {
                    $message->to($user->email)->subject('Update Status: Lembur Ditolak');
                });
            }
        } catch (Exception $e) {
            return back()->with('success', 'Lembur ditolak (Catatan: Email gagal terkirim ke karyawan. Error: ' . $e->getMessage() . ')');
        }

        return back()->with('success', 'Lembur telah ditolak dan karyawan diinformasikan via email.');
    }
}