<?php

namespace App\Http\Controllers;
//
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Karyawan;
use App\Jabatan;
use App\MasterUnitPln;
use App\MasterSubUnit;
use App\MasterProject;
use App\MasterPendidikan;
use App\MasterTad;


class KaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:karyawan']);
    }

    /* ================= HELPER ================= */

    private function getKaryawan()
    {
        return Karyawan::with('jabatan')
            ->where('user_id', auth()->id())
            ->first();
    }

    private function getKaryawanOrFail()
{
    $karyawan = Karyawan::where('user_id', auth()->id())->first();

    if (!$karyawan) {
        abort(403, 'Data karyawan belum dibuat.');
    }

    return $karyawan;
}

    /* ================= STEP 1 ================= */

    public function step1()
    {
        return view('karyawan.step1');
    }

    public function storestep1(Request $r)
    {
        $r->validate([
            'nip' => 'required|string|max:50|unique:karyawan,nip,' . auth()->id() . ',user_id',
            'unitpln_id' => 'required',
            'jabatan_id' => 'required',
            'sub_id' => 'required',
            'tad_id' => 'required',
            'project_id' => 'required',
            'tanggal_mulai_aktif' => 'required',
            'unit_penempatan' => 'required',
            'status_karyawan' => 'required',
        ]);

        Karyawan::updateOrCreate(
            ['user_id' => auth()->id()],
            array_merge(
                $r->only([
                    'nip','unitpln_id','jabatan_id','sub_id','tad_id',
                    'project_id','tanggal_mulai_aktif','unit_penempatan',
                    'status_karyawan','keterangan'
                ]),
                ['user_id' => auth()->id()]
            )
        );
        //

        return redirect()->route('karyawan.step2');
    }

    /* ================= STEP 2 ================= */

    public function step2()
    {
        if (!$this->getKaryawan()) {
            return redirect()->route('karyawan.step1');
        }

        return view('karyawan.step2');
    }

    public function storestep2(Request $r)
{
    $karyawan = $this->getKaryawanOrFail();

    $validated = $r->validate([
        'nama_lengkap' => 'required|string|max:100',
        'nama_panggilan' => 'nullable|string|max:100',
    ]);

    $karyawan->update($validated);

    return redirect()->route('karyawan.step3')
                     ->with('success', 'Data nama berhasil disimpan.');
}

    /* ================= STEP 3 ================= */

    public function step3()
    {
        $karyawan = $this->getKaryawan();
        if (!$karyawan) return redirect()->route('karyawan.step1');

        return view('karyawan.step3', compact('karyawan'));
    }

    public function storestep3(Request $request)
{
    $karyawan = $this->getKaryawanOrFail();

    $rules = [
        'tinggi_badan' => 'nullable|integer|min:0',
        'berat_badan' => 'nullable|integer|min:0',
        'gol_darah' => 'nullable|string|max:3',
        'ukuran_baju' => 'nullable|string|max:10',
        'ukuran_celana' => 'nullable|string|max:10',
        'ukuran_sepatu' => 'nullable|integer|min:0',
    ];

    // Jika satpam, ukuran sepatu wajib
    if ($karyawan->jabatan && $karyawan->jabatan->is_satpam) {
        $rules['ukuran_sepatu'] = 'required|integer|min:0';
    }

    $validated = $request->validate($rules);

    $karyawan->update($validated);

    return redirect()->route('karyawan.step4')
                     ->with('success', 'Data fisik berhasil disimpan.');
}

    /* ================= STEP 4 - 10 ================= */

    public function step4(){ return view('karyawan.step4'); }
    public function step5(){ return view('karyawan.step5'); }
    public function step6(){ return view('karyawan.step6'); }
    public function step7(){ return view('karyawan.step7'); }
    public function step8(){ return view('karyawan.step8'); }
    public function step9(){ return view('karyawan.step9'); }
    public function step10(){ return view('karyawan.step10'); }

   public function storestep4(Request $r)
{
    $karyawan = $this->getKaryawanOrFail();

    $validated = $r->validate([
        'tempat_lahir' => 'required|string|max:100',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:L,P',
        'agama' => 'required|string|max:100',
        'suku_bangsa' => 'nullable|string|max:100',
        'status_nikah' => 'required|string|max:50',
        'jumlah_anak' => 'nullable|integer|min:0',
        'alamat' => 'required|string',
    ]);

    $karyawan->update($validated);

    return redirect()->route('karyawan.step5')
                     ->with('success', 'Data pribadi berhasil disimpan.');
}

public function storestep5(Request $r)
{
    $karyawan = $this->getKaryawanOrFail();

    $validated = $r->validate([
        'no_hp_utama' => 'required|string|max:20',
        'no_hp_cadangan' => 'nullable|string|max:20',
        'email_pribadi' => 'required|email|max:255',
        'instagram' => 'nullable|string|max:255',
        'facebook' => 'nullable|string|max:255',
        'nama_kontak_darurat' => 'required|string|max:100',
    ]);

    $karyawan->update($validated);

    return redirect()->route('karyawan.step6')
                     ->with('success', 'Data kontak berhasil disimpan.');
}

   public function storestep6(Request $r)
{
    $karyawan = $this->getKaryawanOrFail();

    $validated = $r->validate([
        'pendidikan_id' => 'required|exists:pendidikans,id',
        'nama_perguruan' => 'required|string|max:255',
        'file_ijazah' => 'nullable|string'
    ]);

    $karyawan->update($validated);

    return redirect()->route('karyawan.step7')
                     ->with('success', 'Data pendidikan berhasil disimpan.');
}

   public function storestep7(Request $r)
{
    $karyawan = $this->getKaryawanOrFail();

    $validated = $r->validate([
        'no_ktp' => 'required|string',
        'file_ktp' => 'nullable|string',

        'no_kk' => 'required|string',
        'file_kk' => 'nullable|string',

        'no_npwp' => 'nullable|string',
        'file_npwp' => 'nullable|string',

        'no_rg_bank' => 'required|string',
        'nama_bank' => 'required|string',
        'file_buku_tabungan' => 'nullable|string',

        'no_bpjs' => 'nullable|string',
        'file_bpjs' => 'nullable|string',

        'no_rek_bplk' => 'nullable|string',
        'file_buku_bplk' => 'nullable|string',
    ]);

    $karyawan->update($validated);

    return redirect()->route('karyawan.step8')
                     ->with('success', 'Data administrasi berhasil disimpan.');
}

    public function storestep8(Request $r)
    {
        $karyawan = $this->getKaryawanOrFail();
        

        $karyawan->update($r->only([
            'file_surat_lamaran','file_cv',
            'file_pakta_integritas','file_data_consist'
        ]));

        return redirect()->route('karyawan.step9');
    }

   public function storestep9(Request $r)
{
    $karyawan = $this->getKaryawanOrFail();

    $validated = $r->validate([
        'pengalaman_kerja_1' => 'nullable|string',
        'pengalaman_kerja_2' => 'nullable|string',
        'pengalaman_kerja_3' => 'nullable|string',
    ]);

    $karyawan->update($validated);

    return redirect()->route('karyawan.step10')
                     ->with('success', 'Data pengalaman kerja berhasil disimpan.');
}

    public function storestep10(Request $r)
{
    $karyawan = $this->getKaryawanOrFail();

    $validated = $r->validate([
        'tanggal_mcu' => 'required|date',
        'file_hasil_mcu' => 'nullable|string',
        'perokok' => 'required|boolean',
        'penyakit_bawaan' => 'nullable|string',
        'tanggal_skck' => 'required|date',
        'file_skck' => 'nullable|string',
        'tanggal_bnn' => 'required|date',
        'file_bnn' => 'nullable|string',
    ]);

    $karyawan->update($validated);

    return redirect()->route('karyawan.stepkhusus')
                     ->with('success', 'Data kesehatan & SKCK berhasil disimpan.');
}

    /* ================= STEP KHUSUS ================= */

    public function stepKhusus()
    {
        $karyawan = $this->getKaryawan();

        if ($karyawan && $karyawan->jabatan) {

            if ($karyawan->jabatan->is_driver) {
                return view('karyawan.driver', compact('karyawan'));
            }

            if ($karyawan->jabatan->is_satpam) {
                return view('karyawan.satpam', compact('karyawan'));
            }
        }

        return redirect()->route('karyawan.finish');

    }
//
    public function storestepkhusus(Request $r)
{
    $karyawan = $this->getKaryawanOrFail();

    if (!$karyawan->jabatan) {
        abort(400, 'Jabatan belum dipilih.');
    }

    // ================= DRIVER =================
    if ($karyawan->jabatan->is_driver) {

        $validated = $r->validate([
            'no_sim_a' => 'required|string',
            'masa_berlaku_sim' => 'required|date',
            'file_sim' => 'nullable|string',
            'jumlah_tilang_6_bulan' => 'nullable|integer'
        ]);

        $karyawan->update($validated);
    }

    // ================= SATPAM =================
    if ($karyawan->jabatan->is_satpam) {

        $validated = $r->validate([
            'no_kta' => 'required|string',
            'masa_berlaku_kta' => 'required|date',
            'file_kta' => 'nullable|string',
            'pangkat_garda' => 'required|string',
            'no_sertifikat_garda' => 'required|string',
            'file_sertifikat_garda' => 'nullable|string'
        ]);

        $karyawan->update($validated);
    }

    return redirect()->route('karyawan.finish')
                     ->with('success', 'Data khusus berhasil disimpan.');
}

    /* ================= FINISH ================= */

   public function finish()
{
    $karyawan = $this->getKaryawanOrFail();

    $karyawan->update([
        'tanggal_input' => now(),
        'is_complete' => true
    ]);

    return redirect()->route('karyawan.dashboard')
                     ->with('success', 'Data berhasil diselesaikan.');
}
    /* ================= DASHBOARD ================= */

    public function dashboard()
{
    $karyawan = $this->getKaryawan();

    if (!$karyawan || !$karyawan->is_complete) {
        return redirect()->route('karyawan.step1');
    }

    return view('karyawan.dashboard', compact('karyawan'));
}

public function profile()
{
    $karyawan = auth()->user()->karyawan;
    return view('karyawan.profile', compact('karyawan'));
}

public function updateProfile(Request $request)
{
    $karyawan = auth()->user()->karyawan;

    $karyawan->update($request->all());

    return back()->with('success','Berhasil diupdate');
}


}


//