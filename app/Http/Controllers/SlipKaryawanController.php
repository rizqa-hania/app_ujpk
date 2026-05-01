<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penggajian;
use App\Detail;
use Barryvdh\DomPDF\Facade\Pdf;

class SlipKaryawanController extends Controller
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
    public function index()
    {
        return redirect()->route('periode_karyawan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $karyawanId = auth()->user()->karyawan->id ?? null;

        $detail = Detail::with(['karyawan.jabatan', 'detailKomponen.komponen', 'penggajian'])
            ->where('penggajian_id', $id)
            ->when($karyawanId, function ($query) use ($karyawanId) {
                $query->where('id', $karyawanId);
            })
            ->firstOrFail();

        $terbilang = $this->terbilang($detail->gaji_bersih);

        return view('slip_karyawan.show', compact('penggajian', 'detail', 'terbilang'));
    }

    public function downloadPdf($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $karyawanId = auth()->user()->karyawan->id ?? null;

        $detail = Detail::with(['karyawan.jabatan', 'detailKomponen.komponen', 'penggajian'])
            ->where('penggajian_id', $id)
            ->when($karyawanId, function ($query) use ($karyawanId) {
                $query->where('id', $karyawanId);
            })
            ->firstOrFail();

        $terbilang = $this->terbilang($detail->gaji_bersih);
        $pdf = Pdf::loadView('laporan.slippdf', compact('detail', 'terbilang'));

        return $pdf->download('slip_gaji_'.preg_replace('/[^A-Za-z0-9_-]/', '_', $detail->karyawan->nama_lengkap).'.pdf');
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
        //
    }
}
