<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends Controller
{

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        $loginInput = $request->login;

        // Cari user berdasarkan email / username / nip
        $user = User::where('email', $loginInput)
                    ->orWhere('name', $loginInput)
                    ->orWhere('nip', $loginInput)
                    ->first();

        if ($user && Auth::attempt([
            'email' => $user->email,
            'password' => $request->password,
            'is_active' => 1
        ])) {

            $request->session()->regenerate();

            // ADMIN
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // KARYAWAN
            if ($user->role === 'karyawan') {

                if (!$user->is_profile_complete) {
                    return redirect()->route('karyawan.step1');
                }

                return redirect()->route('karyawan.dashboard');
            }
        }

        return back()->withErrors([
            'login' => 'Email / Username / NIP atau password salah'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

}
