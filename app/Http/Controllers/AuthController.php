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


    /*
  public function showRegister()
{
    return view('auth.register');
}

public function sendOtp(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $otp = rand(100000,999999);

    $user = User::firstOrCreate(
        ['email' => $request->email],

    );

    $user->otp = $otp;
    $user->save();

    Mail::raw("Kode OTP kamu: $otp", function ($message) use ($request) {
        $message->to($request->email)
                ->subject('Kode Verifikasi');
    });

    return back()->with('step', 2)->with('email',$request->email);
}

public function verifyOtp(Request $request)
{
    $user = User::where('email',$request->email)
                ->where('otp',$request->otp)
                ->first();

    if(!$user){
        return back()->with('error','OTP Salah')->with('step',2)->with('email',$request->email);
    }

    return redirect()
        ->route('register')
        ->with('step', 3)
        ->with('email', $request->email);
}

public function completeRegister(Request $request)
{
    $user = User::where('email',$request->email)->first();

    $user->update([
        'name'=>$request->name,
        'password'=>Hash::make($request->password),
        'otp'=>null,
        'is_verified'=>true,
        'role'=>'karyawan'
    ]);


    return redirect()->route('login')->with('success', 'Registrasi berhasil!');
}*/

}
