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
    private function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut((int)($nilai/10))." puluh". $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut((int)($nilai/100)) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut((int)($nilai/1000)) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut((int)($nilai/1000000)) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut((int)($nilai/1000000000)) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut((int)($nilai/1000000000000)) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
    }

    private function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }     		
        return $hasil . ' rupiah';
    }


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
            'kode'             => 'required|array',
            'tipe'             => 'required|array',
            'nilai'            => 'required|array',
        ]);

        // Hack Penyelamat Schema (Jika masih ada FK tipe yang bermasalah)
        try {
            if (Schema::hasColumn('detail_komponen', 'tipe')) {
                Schema::table('detail_komponen', function ($table) {
                    try { $table->dropForeign(['tipe']); } catch (\Exception $e) {}
                });
            }
        } catch (\Exception $e) {}

        // 1. Cari atau Buat Header Penggajian Karyawan
        $detail = Detail::firstOrCreate(
            [
                'penggajian_id' => $penggajian_id,
                'id'            => $request->karyawan_id 
            ],
            [
                'kode'             => $request->kode[0], 
                'total_pendapatan' => 0,
                'total_potongan'   => 0,
                'gaji_bersih'      => 0
            ]
        );

        // Fetch Komponen details to know which are percentages
        $allComponents = Komponen::whereIn('kode', $request->kode)->get()->keyBy('kode');

        // 2. First Pass: Process all Pendapatan (Earnings)
        $newPendapatan = 0;
        $pendapatanIndices = [];

        foreach ($request->kode as $index => $kode) {
            $comp = $allComponents->get($kode);
            if ($comp && $comp->tipe == 'pendapatan') {
                $nilai_komponen = $comp->nilai; // Use definition value
                DetailKomponen::create([
                    'detail_id'        => $detail->detail_id,
                    'nip'              => $request->karyawan_id,
                    'kode'             => $kode,
                    'tipe'             => 'pendapatan',
                    'nilai'            => $nilai_komponen
                ]);
                $newPendapatan += $nilai_komponen;
            } else {
                $pendapatanIndices[] = $index; // Save for second pass
            }
        }

        // Update total_pendapatan in header so it can be used for percentage calculations
        $detail->total_pendapatan += $newPendapatan;
        $currentTotalPendapatan = $detail->total_pendapatan;

        // 3. Second Pass: Process all Potongan (Deductions)
        $newPotongan = 0;
        foreach ($request->kode as $index => $kode) {
            $comp = $allComponents->get($kode);
            if ($comp && $comp->tipe == 'potongan') {
                $nilai_komponen = $comp->nilai;

                // Handle percentage calculation
                if ($comp->tipe_penghitungan == 'presentase') {
                    $nilai_komponen = ($nilai_komponen / 100) * $currentTotalPendapatan;
                }

                DetailKomponen::create([
                    'detail_id'        => $detail->detail_id,
                    'nip'              => $request->karyawan_id,
                    'kode'             => $kode,
                    'tipe'             => 'potongan',
                    'nilai'            => $nilai_komponen
                ]);
                
                $newPotongan += $nilai_komponen;
            }
        }

        // 4. Update Header Finals
        $detail->total_potongan += $newPotongan;
        $detail->gaji_bersih = $detail->total_pendapatan - $detail->total_potongan;
        $detail->save();

        return redirect()->route('detail.index', $penggajian_id)->with('success', 'Detail penggajian berhasil ditambahkan.');
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
        $terbilang = $this->terbilang($detail->gaji_bersih);
        
        return view('detail.slip_gaji', compact('detail', 'terbilang'));
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
        $detail = Detail::find($id);

        if ($detail) {
            $penggajian_id = $detail->penggajian_id;
            
            // Hapus rincian komponen terlebih dahulu dikarenakan constraint foreign key
            DetailKomponen::where('detail_id', $id)->delete();
            
            // Hapus data utama detail
            $detail->delete();

            return redirect()->route('detail.index', $penggajian_id)->with('success', 'Rincian gaji karyawan berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    public function tambahkomponen()
    {
        //
    }
}
