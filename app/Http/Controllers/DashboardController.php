<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function super()
    {
        return view('dashboard.super');
    }

    public function admin()
    {
        return view('dashboard.admin');
    }

    public function karyawan()
    {
        return view('dashboard.karyawan');
    }
}