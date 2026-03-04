<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProfileComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && !$user->is_profile_complete) {
            // Kalau profile belum lengkap, redirect ke form step1
            return redirect()->route('karyawan.step1');
        }

        // Kalau sudah lengkap, lanjut request
        return $next($request);
    }
}