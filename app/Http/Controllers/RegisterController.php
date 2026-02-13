<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
public function register(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6'
    ]);

    $karyawan = \App\Models\Karyawan::create([
        'nama' => $request->nama,
        'nip' => uniqid(), // atau sistem NIP kamu
    ]);

    \App\Models\User::create([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'karyawan',
        'karyawan_id' => $karyawan->id
    ]);

    return redirect()->route('login')->with('success','Register berhasil, silakan login');
}

}
