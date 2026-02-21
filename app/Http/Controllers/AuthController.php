<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;    
use App\User; 

class AuthController extends Controller
{
    // Tampil login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        //
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Ambil user dari database berdasarkan email
        $user = User::where('email', $request->email)->first();

        if($user && Hash::check($request->password, $user->password))
        {
            Auth::login($user); // login user

            // arahkan sesuai role
            switch($user->role){
                case 'super_admin':
                    return redirect('/super-admin/dashboard');
                case 'admin':
                    return redirect('/admind/dashboard');
                default:
                    return redirect('/karyawan/dashboard');
            }
        }

        return back()->with('error', 'Email atau password salah');
    }
    //REGISTER KARYAWAN 
    public function showRegisterKaryawan()
    {
        return view('auth.register');
    }

    public function registerKaryawan(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'karyawan'
        ]);

        return redirect('/login')->with('success','Registrasi berhasil');
    }

    //FORGOT PASSWORD 
    public function showForgotPassword()
    {
        return view('auth.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['success' => 'Link reset password telah dikirim ke email.'])
                    : back()->withErrors(['email' => 'Email tidak ditemukan']);
    }

    public function showResetPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect('/login')->with('success', 'Password berhasil direset')
                    : back()->withErrors(['email' => [__($status)]]);
    }

    //LOGOUT
    public function logout()
    {
        Auth::logout();
        //
        return redirect('/login');
    }
}
//