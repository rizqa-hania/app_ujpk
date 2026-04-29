<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Penggajian; // Pastikan model ini sudah ada

class PeriodeKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $query = Penggajian::query();

        if ($request->filled('dari_tanggal') && $request->filled('sampai_tanggal')) {
            $dari   = Carbon::parse($request->dari_tanggal);
            $sampai = Carbon::parse($request->sampai_tanggal);

            // Ambil bulan & tahun dari input tanggal
            $dariBulan   = (int) $dari->format('n');
            $dariTahun   = (int) $dari->format('Y');
            $sampaiBulan = (int) $sampai->format('n');
            $sampaiTahun = (int) $sampai->format('Y');

            // Mapping nama bulan Indonesia ke angka
            $namaBulan = [
                1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
                4  => 'April',    5  => 'Mei',      6  => 'Juni',
                7  => 'Juli',     8  => 'Agustus',  9  => 'September',
                10 => 'Oktober',  11 => 'November', 12 => 'Desember',
            ];

            // Kumpulkan semua bulan-tahun dalam rentang filter
            $rentang = [];
            $current = Carbon::create($dariTahun, $dariBulan, 1);
            $end     = Carbon::create($sampaiTahun, $sampaiBulan, 1);

            while ($current->lte($end)) {
                $rentang[] = [
                    'bulan' => $namaBulan[$current->month],
                    'tahun' => $current->year,
                ];
                $current->addMonth();
            }

            // Filter: periode_bulan & periode_tahun masuk dalam rentang
            $query->where(function ($q) use ($rentang) {
                foreach ($rentang as $r) {
                    $q->orWhere(function ($q2) use ($r) {
                        $q2->where('periode_bulan', $r['bulan'])
                           ->where('periode_tahun', $r['tahun']);
                    });
                }
            });
        }

        // Ambil data detail khusus untuk karyawan yang sedang login (jika ada)
        $karyawan_id = auth()->user()->karyawan->id ?? null;
        $query->with(['detail' => function($q) use ($karyawan_id) {
            $q->where('id', $karyawan_id);
        }]);

        $periodeKaryawan = $query->orderBy('periode_tahun', 'desc')
                                 ->orderBy('periode_bulan', 'desc')
                                 ->get();

        return view('periode_karyawan.index', compact('periodeKaryawan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $periode = PeriodeKaryawan::findOrFail($id);
        return view('periode_karyawan.show', compact('periode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}