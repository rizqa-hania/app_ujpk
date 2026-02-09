<?php

namespace App\Http\Controllers;

use App\Karyawan;
use Illuminate\Http\Request;
use App\Jabatan;
use App\MasterUnitPln;
use App\MasterSubUnit;
use App\MasterProject;
use App\MasterPendidikan;
use App\MasterTad;


class KaryawanController extends Controller
{

    public function index()
    {
        $karyawan = Karyawan::where('nip',auth()->user()->nip)->first();

        if (!$karyawan || $karyawan->tanggal_input == null) {
            return redirect()->route('karyawan.step1');
        }

        return redirect()->route('karyawan.dashboard');
    }

    public function step1()
    {
        return view('karyawan.step1');
    }

    public function storestep1(Request $r)
    {
        Karyawan::updateorcreate(
            ['nip' => auth()->user()->nip],
            $r->only([
                'nip','unitpln_id','jabatan_id','sub_id','tad_id','project_id','tanggal_mulai_aktif','unit_penempatan','status_karyawan','keterangan',

            ])
        );
            return redirect()->route('karyawan.step2');

    }

    public function step2()
    {
        return view('karyawan.step2');
    }

    public function storestep2(Request $r)
    {
        Karyawan::where('nip', auth()-> user-> nip)->update(
            $r->only(['nama_depan','nama_belakang','nama_panggilan'])
        );

        return redirect()->route('karyawan.step3');
    }

    public function step3()
    {

        return view('karyawan.step3');
    }

    public function storestep3(Request $request)
    {
        $karyawan = Karyawan::with('jabatan')->where('nip',auth()->user()->nip)->first();

        //validasi nih buat semua karyawan
        $rules = [
            'tinggi_badan' => 'nullable|integer',
            'berat_badan' => 'nullable|integer',
            'gol_darah' => 'nullable',
            'ukuran_baju' => 'nullable',
            'ukuran_celana' => 'nullable',
        ];

        // ini khusus satpam
        if ($karyawan->jabatan->is_satpam){
            $rules['ukuran_sepatu'] = 'required|integer';
        }

        $validated = $request->validate($rules);

        // ini simpen data 
         $data = [
        'tinggi_badan'  => $validated['tinggi_badan'] ?? null,
        'berat_badan'   => $validated['berat_badan'] ?? null,
        'gol_darah'     => $validated['gol_darah'] ?? null,
        'ukuran_baju'   => $validated['ukuran_baju'] ?? null,
        'ukuran_celana' => $validated['ukuran_celana'] ?? null,
        ];

        // simpen ukuran sepatu 
        if ($karyawan->jabatan->is_satpam) {
            $data['ukuran_sepatu'] = $validated['ukuran_sepatu'];
        }

        $karyawan->update($data);

        return redirect()->route('karyawan.step4');
        }

    public function step4()
    {
        return view('karyawan.step4');
    }

    public function storestep4(Request $r)
    {
        karyawan::where('nip', auth()->user()->nip)->update(
            $r->only(['tempat_lahir','tanggal_lahir','jenis_kelamin','agama','suku_bangsa','status_nikah','jumlah_anak','alamat'
            ])
        );

        return redirect()->route('karyawan.step5');
    }

    public function step5()
    {
        return view('karyawan.step5');
    }

    public function storestep5(Request $r)
    {
        Karyawan::where('nip',auth()->user()->nip)->update(
            $r->only([ 'no_hp_utama','no_hp_cadangan','email_pribadi','instagram','facebook','nama_kontak_darurat'])

        );

        return redirect()->route('karyawan.step6');
    }


    public function step6()
    {
        return view('karyawan.step6');
    }

    public function storestep6(Request $r)
    {
        Karyawan::where('nip',auth()->user()->nip)->update(
            $r->only(['pendidikan_id','nama_perguruan','file_ijazah'])
        );

        return redirect()->route('karyawan.step7');
    }

    public function step7()
    {
        return view('karyawan.step7');
    }

    public function storestep7(Request $r)
    {
        Karyawan::where('nip', auth()->user()->nip)->update(
            $r->only(['no_ktp','file_ktp','no_kk','file_kk','no_npwp','file_npwp','no_rg_bank','nama_bank','file_buku_tabungan','no_bpjs','file_bpjs','no_rek_bplk','file_buku_bplk'])
        );
 
        return redirect()->route('karyawan.step8');
    }

    public function step8()
    {
        return view('karyawan.step8');
    }

    public function storestep8(Request $r)
    {
        Karyawan::where('nip', auth()->user()->nip)->update(
            $r->only(['file_surat_lamaran','file_cv','file_pakta_integritas','file_date_consist'])
        );

        return redirect()->route('karyawan.step9');
    }

    public function step9()
    {
        return view('karyawan.step9');
    }

    public function storestep9(Request $r)
    {
        Karyawan::where('nip',auth()->user()->nip)->update(
            $r->only(['pengalaman_kerja_1','pengalaman_kerja_2','pengalaman_kerja_3'])
        );

        return redirect()->route('karyawan.step10');
    }

    public function step10()
    {
        return view('karyawan.step10');
    }

    public function storestep10(Request $r)
    {
        Karyawan::where('nip',auth()->user()->nip)->update(
            $r->only(['tanggal_mcu','file_hasil_mcu','perokok','penyakit_bawaan','tanggal_skck','file_skck','tanggal_bnn','file_bnn'])
        );

        return redirect()->route('karyawan.stepkhusus');
    }

    public function stepKhusus()
    {
        $karyawan = Karyawan::with('jabatan')
            ->where('nip', auth()->user()->nip)
            ->first();

        if ($karyawan->jabatan->is_driver) {
            return view('karyawan.driver');
        }

        if ($karyawan->jabatan->is_satpam) {
            return view('karyawan.satpam');
        }

        return redirect()->route('karyawan.finish');
    }

    public function storestepkhusus(Request $r)
    {
        $karyawan = Karyawan::with('jabatan')
            ->where('nip', auth()->user()->nip)
            ->first();

        if ($karyawan->jabatan->is_driver) {
            $karyawan->update(
                $r->only([
                    'no_sim_a',
                    'masa_berlaku_sim',
                    'file_sim',
                    'jumlah_tilang_6_bulan'
                ])
            );
        }

        if ($karyawan->jabatan->is_satpam) {
            $karyawan->update(
                $r->only([
                    'no_kta',
                    'masa_berlaku_kta',
                    'file_kta',
                    'pangkat_garda',
                    'no_sertifikat_garda',
                    'file_sertifikat_garda'
                ])
            );
        }

        return redirect()->route('karyawan.finish');
    }

    public function finish()
    {
        Karyawan::where('nip', auth()->user()->nip)->update(['tanggal_input' => now()]);

        return redirect()->route('karyawan.dashboard');
    }

    public function dashboard()
    {
        return view('karyawan.dashboard');
    }

}