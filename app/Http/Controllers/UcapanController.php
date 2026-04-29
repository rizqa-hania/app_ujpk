<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UcapanController extends Controller
{
    public function kirim(Request $request)
    {
        DB::table('ucapan')->insert([
            'karyawan_id' => $request->karyawan_id,
            'pesan' => $request->pesan,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['success' => true]);
    }
}