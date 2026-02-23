<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\User;

class AuthController extends Controller
{

    public function showLogin()
    {
        return view('auth.login');
    }


   public function login(Request $request) {
    $credentials = $request->validate([
        'email'=>'required|email',
        'password'=>'required'
    ]);

    if(Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Redirect berdasarkan role
        if(Auth::user()->role == 'admin'){
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('karyawan.dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'Email atau password salah'
    ]);
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

  public function showRegister()
{
    return view('auth.register');
}

public function sendOtp(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $otp = rand(100000,999999);

    $user = User::updateOrCreate(
        ['email' => $request->email],
        ['otp' => $otp]
    );

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
        return back()->with('error','OTP Salah');
    }

    return back()->with('step',3)->with('email',$request->email);
}

public function completeRegister(Request $request)
{
    $user = User::where('email',$request->email)->first();

    $user->update([
        'name'=>$request->name,
        'password'=>Hash::make($request->password),
        'otp'=>null,
        'is_verified'=>true
    ]);

    return redirect('/login');
}
}
//