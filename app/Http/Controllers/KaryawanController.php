<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Karyawan;
use App\Jabatan;
use App\MasterUnitPln;
use App\MasterSubUnit;
use App\MasterProject;
use App\MasterPendidikan;
use App\MasterTad;
//

class KaryawanController extends Controller
{
    private function getKaryawan()
    {
        return Karyawan::with('jabatan')
            ->where('nip', auth()->user()->nip)
            ->first();
    }

    /* ================= STEP 1 ================= */

    public function step1()
    {
        return view('karyawan.step1');
    }

    public function storestep1(Request $r)
    {
        $r->validate([
            'nip' => 'required|string|max:50',
            'unitpln_id' => 'required',
            'jabatan_id' => 'required',
            'sub_id' => 'required',
            'tad_id' => 'required',
            'project_id' => 'required',
            'tanggal_mulai_aktif' => 'required',
            'unit_penempatan' => 'required',
            'status_karyawan' => 'required',
        ]);

        $karyawan = Karyawan::updateOrCreate(
            ['nip' => $r->nip],
            $r->only([
                'nip','unitpln_id','jabatan_id','sub_id','tad_id',
                'project_id','tanggal_mulai_aktif','unit_penempatan',
                'status_karyawan','keterangan'
            ])
        );

        session(['nip' => $karyawan->nip]);

        return redirect()->route('karyawan.step2');
    }

    /* ================= STEP 2 ================= */

    public function step2()
    {
        return view('karyawan.step2');
    }

    public function storestep2(Request $r)
    {
        $this->getKaryawan()->update(
            $r->only(['nama_depan','nama_belakang','nama_panggilan'])
        );

        return redirect()->route('karyawan.step3');
    }

    /* ================= STEP 3 ================= */

    public function step3()
    {
        $karyawan = $this->getKaryawan();
        return view('karyawan.step3', compact('karyawan'));
    }

    public function storestep3(Request $request)
    {
        $karyawan = $this->getKaryawan();

        //
        $rules = [
            'tinggi_badan' => 'nullable|integer',
            'berat_badan' => 'nullable|integer',
            'gol_darah' => 'nullable',
            'ukuran_baju' => 'nullable',
            'ukuran_celana' => 'nullable',
        ];

        if ($karyawan && $karyawan->jabatan && $karyawan->jabatan->is_satpam) {
        $rules['ukuran_sepatu'] = 'required|integer';
        }


        $validated = $request->validate($rules);

        $karyawan->update($validated);

        return redirect()->route('karyawan.step4');
    }

    /* ================= STEP 4 - 10 ================= */

    public function step4(){ return view('karyawan.step4'); }
    public function step5(){ return view('karyawan.step5'); }
    public function step6(){ return view('karyawan.step6'); }
    public function step7(){ return view('karyawan.step7'); }
    public function step8(){ return view('karyawan.step8'); }
    public function step9(){ return view('karyawan.step9'); }
    public function step10(){ return view('karyawan.step10'); }

    public function storestep4(Request $r){
        $this->getKaryawan()->update($r->only([
            'tempat_lahir','tanggal_lahir','jenis_kelamin','agama',
            'suku_bangsa','status_nikah','jumlah_anak','alamat'
        ]));
        return redirect()->route('karyawan.step5');
    }

    public function storestep5(Request $r){
        $this->getKaryawan()->update($r->only([
            'no_hp_utama','no_hp_cadangan','email_pribadi',
            'instagram','facebook','nama_kontak_darurat'
        ]));
        return redirect()->route('karyawan.step6');
    }

    public function storestep6(Request $r){
        $this->getKaryawan()->update($r->only([
            'pendidikan_id','nama_perguruan','file_ijazah'
        ]));
        return redirect()->route('karyawan.step7');
    }

    public function storestep7(Request $r){
        $this->getKaryawan()->update($r->only([
            'no_ktp','file_ktp','no_kk','file_kk','no_npwp',
            'file_npwp','no_rg_bank','nama_bank','file_buku_tabungan',
            'no_bpjs','file_bpjs','no_rek_bplk','file_buku_bplk'
        ]));
        return redirect()->route('karyawan.step8');
    }

    public function storestep8(Request $r){
        $this->getKaryawan()->update($r->only([
            'file_surat_lamaran','file_cv',
            'file_pakta_integritas','file_date_consist'
        ]));
        return redirect()->route('karyawan.step9');
    }

    public function storestep9(Request $r){
        $this->getKaryawan()->update($r->only([
            'pengalaman_kerja_1','pengalaman_kerja_2','pengalaman_kerja_3'
        ]));
        return redirect()->route('karyawan.step10');
    }

    public function storestep10(Request $r){
        $this->getKaryawan()->update($r->only([
            'tanggal_mcu','file_hasil_mcu','perokok','penyakit_bawaan',
            'tanggal_skck','file_skck','tanggal_bnn','file_bnn'
        ]));
        return redirect()->route('karyawan.stepkhusus');
    }

    /* ================= STEP KHUSUS ================= */

    public function stepKhusus()
    {
        $karyawan = $this->getKaryawan();
       
        if ($karyawan && $karyawan->jabatan && $karyawan->jabatan->is_driver) {
        return view('karyawan.driver', compact('karyawan'));}
        return redirect()->route('karyawan.finish');

        if($karyawan && $karyawan->jabatan && $karyawan->jabatan->is_satpam){
            return view('karyawan.satpam', compact('karyawan'));}
        return redirect()->route('karyawan.finish');
       
    }
    

    public function storestepkhusus(Request $r)
    {
        $karyawan = $this->getKaryawan();

       if ($karyawan && $karyawan->jabatan && $karyawan->jabatan->is_satpam) {
    return view('karyawan.satpam', compact('karyawan'));
}
        if ($karyawan && $karyawan->jabatan && $karyawan->jabatan->is_driver) {
            $karyawan->update(
                $r->only([
                    'no_sim_a',
                    'masa_berlaku_sim',
                    'file_sim',
                    'jumlah_tilang_6_bulan'
                ])
            );
        }

        if ($karyawan && $karyawan->jabatan && $karyawan->jabatan->is_satpam) {
            $karyawan->update($r->only([
                'no_kta','masa_berlaku_kta','file_kta',
                'pangkat_garda','no_sertifikat_garda',
                'file_sertifikat_garda'
            ]));
        }

        return redirect()->route('karyawan.finish');
    }

    public function finish()
    {
        $this->getKaryawan()->update(['tanggal_input' => now()]);
        return redirect()->route('karyawan.dashboard');
    }

    public function dashboard()
    {
        return view('karyawan.dashboard');
    }
    //
}