<?php

namespace App\Http\Controllers;

use App\Detail;
use App\Penggajian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');

        $transaksi = Detail::with('penggajian', 'karyawan.jabatan')
            ->whereHas('penggajian', function($query) use ($startDate, $endDate) {
                // Assuming we filter by created_at of the detail record or the penggajian period
                // Using detail's created_at for simplicity, matching the image's logic
            })
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        return view('laporan.index', compact('transaksi', 'startDate', 'endDate'));
    }

    public function filter(Request $request)
    {
        $dateRange = $request->input('date_range');
        if (empty($dateRange)) {
            return redirect()->route('laporan.index');
        }
        
        $date = explode(' - ', $dateRange);
        $startDate = Carbon::parse($date[0])->format('Y-m-d');
        $endDate = Carbon::parse($date[1])->format('Y-m-d');

        $transaksi = Detail::with('penggajian', 'karyawan.jabatan')
            ->whereBetween('created_at', [$startDate . ' 00:00:01', $endDate . ' 23:59:59'])
            ->get();

        return view('laporan.index', compact('transaksi', 'startDate', 'endDate'));
    }

    public function generatePDF(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $tanggalBulanTahunawal = date("d-m-Y", strtotime($startDate));
        $tanggalBulanTahunakhir = date("d-m-Y", strtotime($endDate));

        $transaksi = Detail::with('penggajian', 'karyawan.jabatan')
            ->whereBetween('created_at', [$startDate . ' 00:00:01', $endDate . ' 23:59:59'])
            ->get();

        $pdf = PDF::loadView('laporan.gajipdf', compact('transaksi', 'tanggalBulanTahunawal', 'tanggalBulanTahunakhir'));
        $pdf->setPaper('A4', 'landscape');

        $namaFile = 'Laporan_Gaji_Periode_' . $tanggalBulanTahunawal . '_' . $tanggalBulanTahunakhir . '.pdf';

        return $pdf->stream($namaFile);
    }

    public function generatePDFByTransaksi($id)
    {
        $detail = Detail::with(['karyawan.jabatan', 'detailKomponen.komponen', 'penggajian'])->findOrFail($id);
        $terbilang = $this->terbilang($detail->gaji_bersih);
        
        $pdf = PDF::loadView('laporan.slippdf', compact('detail', 'terbilang'));
        $pdf->setPaper('A4', 'portrait');

        $namaFile = 'Slip_Gaji_' . ($detail->karyawan->nama_lengkap ?? $id) . '.pdf';

        return $pdf->stream($namaFile);
    }

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
}

