<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detail;
use App\Penggajian;
use App\Karyawan;
use App\Komponen;
use App\DetailKomponen;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $detail = Detail::with('karyawan')->where('penggajian_id', $id)->get();

        return view('detail.index', compact('penggajian', 'detail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $karyawan = Karyawan::all();
        $komponen = Komponen::all();
        $detail = Detail::all();

        return view('detail.create', compact('penggajian', 'karyawan', 'komponen', 'detail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $penggajian_id)
    {
        $request->validate([
            'karyawan_id'      => 'required',
            'nip'              => 'required|string|max:255',
            'kode'             => 'required',
            'tipe'             => 'required',
            'nilai'            => 'required|numeric',
        ]);

        // Cek apakah karyawan ini sudah dibuatkan form detailnya di bulan/penggajian ini, 
        // Jika blm ada, buat auto; jika sdh ada, cukup tambahkan detail ke komponennya sja.
        $detail = Detail::firstOrCreate(
            [
                'penggajian_id' => $penggajian_id,
                'id'            => $request->karyawan_id // id di tabel detail digunakan sbg foreign karyawan (yg dinput adalah karyawan_id dr form)
            ],
            [
                'kode'             => $request->kode,
                'total_pendapatan' => 0,
                'total_potongan'   => 0,
                'gaji_bersih'      => 0
            ]
        );

        // Perbaikan database: Hapus foreign key 'tipe' jika masih ada (karena kesalahan migration asli)
        try {
            if (Schema::hasColumn('detail_komponen', 'tipe')) {
                Schema::table('detail_komponen', function ($table) {
                    // Cek apakah FK ini ada, jika iya hapus.
                    // Ini untuk mengatasi error "Integrity constraint violation"
                    $table->dropForeign('detail_komponen_tipe_foreign');
                });
            }
        } catch (\Exception $e) {
            // Abaikan jika sudah terhapus atau tidak ada
        }

        DetailKomponen::create([
            'detail_id'        => $detail->detail_id,
            'nip'              => $request->nip,
            'kode'             => $request->kode,
            'tipe'             => $request->tipe,
            'nilai'            => $request->nilai
        ]);

        // Opsional: Boleh dibuat auto-calculating juga untuk Total Pendapatan dll disini.
        return redirect()->route('detail.index', $penggajian_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($detail_id)
    {
        $detail = Detail::with(['karyawan.jabatan', 'detailKomponen.komponen', 'penggajian'])->findOrFail($detail_id);
        
        return view('detail.slip_gaji', compact('detail'));
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
        Detail::where('detail_id', $id)->delete();
        return redirect()->route('detail.index');
    }

    public function tambahkomponen()
    {
        //
    }
}
