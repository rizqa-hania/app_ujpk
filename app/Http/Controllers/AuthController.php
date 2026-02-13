<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ================= LOGIN =================

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'

        ]);

        // Cek autentikasi
        if (Auth::attempt($request->only('email', 'password'))) {

            $request->session()->regenerate();
            $user = Auth::user();

            // Cek role
            if ($user->role == 'superadmin') {
                return redirect('/superadmin/dashboard');
            } elseif ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/karyawan/dashboard');
            }
        }

        // Jika gagal
        return back()->with('error', 'Login gagal, periksa email dan password');
    }

    // ================= REGISTER =================

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'karyawan'
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat, silakan login');
    }

    // ================= FORGOT PASSWORD =================

    public function showForgot()
    {
        return view('auth.forgot');
    }

    public function sendReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        // Sementara kita buat reset sederhana (tanpa email)
        return back()->with('success', 'Link reset password berhasil dikirim (simulasi)');
    }

    // ================= LOGOUT =================

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
