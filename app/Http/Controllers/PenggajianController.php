<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Penggajian;

class PenggajianController extends Controller
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
        $dariBulan   = (int) $dari->format('n');   // 1-12 (tanpa leading zero)
        $dariTahun   = (int) $dari->format('Y');
        $sampaiBluan = (int) $sampai->format('n');
        $sampaiTahun = (int) $sampai->format('Y');

        // Mapping nama bulan Indonesia ke angka
        $namaBulan = [
            1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
            4  => 'April',    5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',     8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',  11 => 'November',  12 => 'Desember',
        ];

        // Kumpulkan semua bulan-tahun dalam rentang filter
        $rentang = [];
        $current = Carbon::create($dariTahun, $dariBulan, 1);
        $end     = Carbon::create($sampaiTahun, $sampaiBluan, 1);

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

    $penggajian = $query->orderBy('periode_tahun', 'desc')
                        ->orderBy('periode_bulan', 'desc')
                        ->get();

    return view('penggajian.index', compact('penggajian'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penggajian.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode_bulan' => 'required|string',
            'periode_tahun' => 'required|integer',
            'status' => 'required|string',
        ]);

        Penggajian::create([
            'periode_bulan' => $request->periode_bulan,
            'periode_tahun' => $request->periode_tahun,
            'status' => $request->status
        ]);

        return redirect()->route('penggajian.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Penggajian::where('penggajian_id', $id)->delete();
        return redirect()->route('penggajian.index');
    }
}
