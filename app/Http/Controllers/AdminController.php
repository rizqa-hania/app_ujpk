<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Karyawan;

class AdminController extends Controller
{

    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil dibuat');
    }

    public function destroy($id)
    {
        User::where('user_id', $id)->where('role', 'admin')->delete();

        return back()->with('success', 'Admin berhasil dihapus');
    }

    // Method untuk menampilkan data karyawan
    public function karyawanIndex()
    {
        $karyawans = User::where('role', 'karyawan')
            ->with(['karyawan' => function($q) {
                $q->with(['jabatan', 'unitpln', 'subunit', 'tad', 'project', 'pendidikan']);
            }])
            ->get();

        return view('admin.karyawan.index', compact('karyawans'));
    }

    // Method untuk melihat detail karyawan
    public function karyawanShow($id)
    {
        $user = User::where('user_id', $id)->with(['karyawan' => function($q) {
            $q->with(['jabatan', 'unitpln','subunit','tad','project','pendidikan']);
        }])->firstOrFail();

        return view('admin.karyawan.show', compact('user'));
    }
}
