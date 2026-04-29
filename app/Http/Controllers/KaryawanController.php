<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Karyawan;
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
      
        $karyawans = User::where('role', 'karyawan')->get();
        return view('karyawan.tambah.index', compact('karyawans'));
    }

    public function create()
    {
        return view('karyawan.tambah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
           'nip' => 'required|numeric|unique:users,nip',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
        'name' => $request->name,
        'nip' => $request->nip,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'karyawan'
]);

        return redirect()->route('karyawan.tambah.index')->with('success', 'Karyawan berhasil dibuat');
    }

    public function destroy($id)
    {
        User::where('user_id', $id)->where('role', 'karyawan')->delete();

        return back()->with('success', 'Karyawan berhasil dihapus');
    }




    public function __construct()
    {
        $this->middleware('auth');
    }

    private function getCurrentUserId()
    {
        // Pertama coba dari session (untuk input data tanpa login)
        if (session()->has('karyawan_user_id')) {
            return session('karyawan_user_id');
        }
        // Kedua coba dari auth
        if (auth()->check() && auth()->user()) {
            return auth()->user()->user_id;
        }
        return null;
    }

    private function getKaryawan()
    {
        $userId = $this->getCurrentUserId();
        
        if ($userId) {
            return Karyawan::where('user_id', $userId)->first();
        }
        return null;
    }

    private function getKaryawanOrFail()
    {
        $userId = $this->getCurrentUserId();
        
        if (!$userId) {
            throw new \Exception('User tidak ditemukan. Silakan login atau pilih karyawan terlebih dahulu.');
        }
        
        return Karyawan::where('user_id', $userId)->firstOrFail();
    }

    private function getOrCreateKaryawan()
    {
        $karyawan = $this->getKaryawan();
        $userId = $this->getCurrentUserId();
        
        if (!$karyawan && $userId) {
            $karyawan = Karyawan::create([
                'user_id' => $userId,
                'status_karyawan' => 'aktif'
            ]);
        }
        
        return $karyawan;
    }
    
    /* ================= CREATE NEW USER & KARYAWAN ================= */
    
    public function createNew(Request $request)
    {
        // Buat user baru untuk karyawan
        $user = User::create([
            'name' => $request->input('nama_karyawan', 'Karyawan Baru-' . date('His')),
            'email' => 'karyawan_' . time() . '@example.com',
            'password' => bcrypt('password123'),
            'role' => 'karyawan',
            'is_verified' => true
        ]);
        
        // Simpan user_id di session
        session(['karyawan_user_id' => $user->user_id]);
        
        return redirect()->route('karyawan.step1');
    }

    /* ================= DASHBOARD ================= */

   public function dashboard()
{
    $karyawan = $this->getKaryawan();
    
    if (!$karyawan || !$karyawan->is_complete) {
        return redirect()->route('karyawan.step1');
    }

    $today = Carbon::today();

    $ulangTahunHariIni = Karyawan::whereMonth('tanggal_lahir', $today->month)
        ->whereDay('tanggal_lahir', $today->day)
        ->get();

    return view('dashboard.karyawan.dashboard', 
        compact('karyawan', 'ulangTahunHariIni')
    );
}

    /* ================= STEP 1: DATA KERJA ================= */

    public function step1()
    {
        $user = auth()->user();
        $karyawan = $this->getKaryawan();
        $unitpln = MasterUnitPln::all();
        $jabatan = Jabatan::all();
        $subunit = MasterSubUnit::all();
        $tad = MasterTad::all();
        $project = MasterProject::all();
        $pendidikan = MasterPendidikan::all();

        return view('karyawan.step1', compact('karyawan', 'unitpln', 'jabatan', 'subunit', 'tad', 'project', 'pendidikan','user'));
    }

    public function storestep1(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:50',
            'unitpln_id' => 'required',
            'jabatan_id' => 'required',
            'sub_id' => 'required',
            'tad_id' => 'required',
            'project_id' => 'required',
            'pendidikan_id' => 'required',
              'tanggal_mulai_aktif' => 'required',
            'unit_penempatan' => 'required',
                    'status_karyawan' => 'required',
            'keterangan' => 'nullable',
        ]);

        $userId = $this->getCurrentUserId();
        
        if (!$userId) {
            return redirect()->back()->with('error', 'User ID tidak ditemukan. Silakan buat karyawan baru terlebih dahulu.');
        }

        // Cek apakah NIP sudah digunakan oleh karyawan lain
        $existingKaryawan = Karyawan::where('nip', $validated['nip'])->first();
        
        if ($existingKaryawan && $existingKaryawan->user_id != $userId) {
            return redirect()->back()->with('error', 'NIP tersebut sudah digunakan oleh karyawan lain. Silakan gunakan NIP yang berbeda.');
        }

        // Cek apakah sudah ada karyawan untuk user ini
        $karyawan = $this->getKaryawan();
        
        if ($karyawan) {
            // Update data yang ada
            $karyawan->update($validated);
        } else {
            // Buat karyawan baru dengan data yang sudah divalidasi
            Karyawan::create(array_merge($validated, [
                'user_id' => $userId
            ]));
        }

        return redirect()->route('karyawan.step2');
    }

    /* ================= STEP 2: DATA PRIBADI ================= */

    public function step2()
    {
        $karyawan = $this->getKaryawan();
        
        if (!$karyawan) {
            return redirect()->route('karyawan.step1');
        }

        return view('karyawan.step2', compact('karyawan'));
    }

    public function storestep2(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();

        $validated = $request->validate([
            'nama_lengkap' => 'nullable|string|max:100',
            'nama_panggilan' => 'nullable|string|max:100',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'agama' => 'nullable|string|max:50',
            'suku_bangsa' => 'nullable|string|max:50',
            'status_nikah' => 'nullable|in:belum_menikah,sudah_nikah,cerai',
            'jumlah_anak' => 'nullable|integer|min:0',
            'alamat' => 'nullable|string',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.step3');
    }

    /* ================= STEP 3: DATA FISIK ================= */

    public function step3()
    {
        $karyawan = $this->getKaryawan();
        
        if (!$karyawan) {
            return redirect()->route('karyawan.step1');
        }

        return view('karyawan.step3', compact('karyawan'));
    }

    public function storestep3(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();

        $validated = $request->validate([
            'tinggi_badan' => 'nullable|integer|min:0',
            'berat_badan' => 'nullable|integer|min:0',
            'gol_darah' => 'nullable|in:A,B,AB,O',
            'ukuran_baju' => 'nullable|string|max:10',
            'ukuran_celana' => 'nullable|string|max:10',
            'ukuran_sepatu' => 'nullable|integer|min:0',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.step4');
    }

    /* ================= STEP 4: KONTAK ================= */

    public function step4()
    {
        $karyawan = $this->getKaryawan();
        
        if (!$karyawan) {
            return redirect()->route('karyawan.step1');
        }

        return view('karyawan.step4', compact('karyawan'));
    }

    public function storestep4(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();

        $validated = $request->validate([
            'no_HP_utama' => 'nullable|string|max:20',
            'no_HP_cadangan' => 'nullable|string|max:20',
            'email_pribadi' => 'nullable|email|max:100',
            'instagram' => 'nullable|string|max:100',
            'facebook' => 'nullable|string|max:100',
            'nama_kontak_darurat' => 'nullable|string|max:100',
            'nomor_darurat' => 'nullable|string|max:20',
            'email_darurat' => 'nullable|email|max:100',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.step5');
    }

    /* ================= STEP 5: PENDIDIKAN ================= */

    public function step5()
    {
        $karyawan = $this->getKaryawan();
        $pendidikan = MasterPendidikan::all();
        
        if (!$karyawan) {
            return redirect()->route('karyawan.step1');
        }

        return view('karyawan.step5', compact('karyawan', 'pendidikan'));
    }

    public function storestep5(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();

        $validated = $request->validate([
            'pendidikan_id' => 'required',
            'nama_perguruan' => 'nullable|string|max:255',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.step6');
    }

    /* ================= STEP 6: IDENTITAS RESMI ================= */

    public function step6()
    {
        $karyawan = $this->getKaryawan();
        
        if (!$karyawan) {
            return redirect()->route('karyawan.step1');
        }

        return view('karyawan.step6', compact('karyawan'));
    }

    public function storestep6(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();

        $validated = $request->validate([
            'no_ktp' => 'nullable|string|max:30',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'no_kk' => 'nullable|string|max:30',
            'file_kk' =>'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'no_npwp' => 'nullable|string|max:30',
            'file_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.step7');
    }

    /* ================= STEP 7: BANK & BPJS ================= */

    public function step7()
    {
        $karyawan = $this->getKaryawan();
        
        if (!$karyawan) {
            return redirect()->route('karyawan.step1');
        }

        return view('karyawan.step7', compact('karyawan'));
    }

    public function storestep7(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();

        $validated = $request->validate([
            'no_rg_bank' => 'nullable|string|max:30',
            'nama_bank' => 'nullable|string|max:50',
            'file_buku_tabungan' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'no_bpjs' => 'nullable|string|max:30',
            'file_bpjs' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'no_bpjstk' => 'nullable|string|max:30',
            'file_bpjstk' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'no_rek_bplk' => 'nullable|string|max:30',
            'file_buku_bplk' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.step8');
    }

    /* ================= STEP 8: DOKUMEN ================= */

    public function step8()
    {
        $karyawan = $this->getKaryawan();
        
        if (!$karyawan) {
            return redirect()->route('karyawan.step1');
        }

        return view('karyawan.step8', compact('karyawan'));
    }

    public function storestep8(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();

        $validated = $request->validate([
            'file_surat_lamaran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'file_cv' =>'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'file_pakta_integritas' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'file_data_consist' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.step9');
    }

    /* ================= STEP 9: PENGALAMAN KERJA ================= */

    public function step9()
    {
        $karyawan = $this->getKaryawan();
        
        if (!$karyawan) {
            return redirect()->route('karyawan.step1');
        }

        return view('karyawan.step9', compact('karyawan'));
    }

    public function storestep9(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();

        $validated = $request->validate([
            'pengalaman_kerja_1' => 'nullable|string',
            'pengalaman_kerja_2' => 'nullable|string',
            'pengalaman_kerja_3' => 'nullable|string',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.step10');
    }

    /* ================= STEP 10: KESEHATAN ================= */

    public function step10()
    {
        $karyawan = $this->getKaryawan();
        
        if (!$karyawan) {
            return redirect()->route('karyawan.step1');
        }

        return view('karyawan.step10', compact('karyawan'));
    }

    public function storestep10(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();

        $validated = $request->validate([
            'tanggal_mcu' => 'nullable|date',
            'file_hasil_mcu' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'perokok' => 'nullable|boolean',
            'penyakit_bawaan' => 'nullable|string',
            'tanggal_skck' => 'nullable|date',
            'file_skck' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'tanggal_bnn' => 'nullable|date',
            'file_bnn' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
        ]);

        $karyawan->update($validated);

        // Check if karyawan is driver or satpam based on kode_jabatan
        // 03 = Satpam, 06 = Driver
        if ($karyawan->jabatan) {
            $kodeJabatan = $karyawan->jabatan->kode_jabatan ?? '';
            if (strpos($kodeJabatan, '03') !== false || strpos($kodeJabatan, '06') !== false) {
                return redirect()->route('karyawan.step11');
            }
        }

        return $this->finish($karyawan);
    }

    /* ================= STEP 11: DRIVER/SATPAM ================= */

    public function step11()
    {
        $karyawan = $this->getKaryawan();
        
        if (!$karyawan) {
            return redirect()->route('karyawan.step1');
        }

        return view('karyawan.step11', compact('karyawan'));
    }

    public function storestep11(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();

        $validated = $request->validate([
            'no_sim_a' => 'nullable|string|max:30',
            'masa_berlaku_sim' => 'nullable|date',
            'file_sim' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'jumlah_tilang_6_bulan' => 'nullable|integer|min:0',
            'no_kta' => 'nullable|string|max:30',
            'masa_berlaku_kta' => 'nullable|date',
            'file_kta' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'pangkat_garda' => 'nullable|in:pratama,madya,utama',
            'no_sertifikat_garda' => 'nullable|string|max:50',
            'file_sertifikat_garda' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
        ]);

        $karyawan->update($validated);

        return $this->finish($karyawan);
    }

    /* ================= FINISH ================= */

    public function finish($karyawan = null)
{
    if (!$karyawan) {
        $karyawan = $this->getKaryawanOrFail();
    }

    // Tandai karyawan selesai
    $karyawan->update([
        'tanggal_input' => now(),
        'is_complete' => true
    ]);

    // Tandai profile lengkap di tabel users
    $user = Auth::user();
    $user->is_profile_complete = true;
    $user->save();

    // Hapus session sementara
    session()->forget('karyawan_user_id');

    // Redirect ke dashboard
    return redirect()->route('karyawan.dashboard')
        ->with('success', 'Selamat! Data karyawan berhasil disimpan lengkap.');
}
    /* ================= PROFILE ================= */

    public function profile()
    {
        $karyawan = $this->getKaryawanOrFail();
        
        $unitpln = MasterUnitPln::all();
        $jabatan = Jabatan::all();
        $subunit = MasterSubUnit::all();
        $tad = MasterTad::all();
        $project = MasterProject::all();
        $pendidikan = MasterPendidikan::all();

        return view('karyawan.profile.profile', compact('karyawan', 'unitpln', 'jabatan', 'subunit', 'tad', 'project', 'pendidikan'));
    }

    

    public function updateProfile(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();

        $validated = $request->validate([
            'nip' => 'required|string|max:50|unique:karyawan,nip,' . $karyawan->id,
            'unitpln_id' => 'required',
            'jabatan_id' => 'required',
            'sub_id' => 'required',
            'tad_id' => 'required',
            'project_id' => 'required',
            'pendidikan_id' => 'required',
            'tanggal_mulai_aktif' => 'required',
            'unit_penempatan' => 'required',
            'status_karyawan' => 'required',
            'keterangan' => 'nullable',
            'nama_lengkap' => 'nullable|string|max:100',
            'nama_panggilan' => 'nullable|string|max:100',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'agama' => 'nullable|string|max:50',
            'suku_bangsa' => 'nullable|string|max:50',
            'status_nikah' => 'nullable|in:belum_menikah,sudah_nikah,cerai',
            'jumlah_anak' => 'nullable|integer|min:0',
            'alamat' => 'nullable|string',
            'tinggi_badan' => 'nullable|integer|min:0',
            'berat_badan' => 'nullable|integer|min:0',
            'gol_darah' => 'nullable|in:A,B,AB,O',
            'ukuran_baju' => 'nullable|string|max:10',
            'ukuran_celana' => 'nullable|string|max:10',
            'ukuran_sepatu' => 'nullable|integer|min:0',
            'no_HP_utama' => 'nullable|string|max:20',
            'no_HP_cadangan' => 'nullable|string|max:20',
            'email_pribadi' => 'nullable|email|max:100',
            'instagram' => 'nullable|string|max:100',
            'facebook' => 'nullable|string|max:100',
            'nama_kontak_darurat' => 'nullable|string|max:100',
            'nomor_darurat' => 'nullable|string|max:20',
            'email_darurat' => 'nullable|email|max:100',
            'nama_perguruan' => 'nullable|string',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'no_ktp' => 'nullable|string|max:30',
            'file_ktp' =>'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'no_kk' => 'nullable|string|max:30',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'no_npwp' => 'nullable|string|max:30',
            'file_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'no_rg_bank' => 'nullable|string|max:30',
            'nama_bank' => 'nullable|string|max:50',
            'file_buku_tabungan' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'no_bpjs' => 'nullable|string|max:30',
            'file_bpjs' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'no_bpjstk' => 'nullable|string|max:30',
            'file_bpjstk' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'no_rek_bplk' => 'nullable|string|max:30',
            'file_buku_bplk' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'file_surat_lamaran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'file_cv' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'file_pakta_integritas' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'file_data_consist' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'pengalaman_kerja_1' => 'nullable|string',
            'pengalaman_kerja_2' => 'nullable|string',
            'pengalaman_kerja_3' => 'nullable|string',
            'tanggal_mcu' => 'nullable|date',
            'file_hasil_mcu' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'perokok' => 'nullable|boolean',
            'penyakit_bawaan' => 'nullable|string',
            'tanggal_skck' => 'nullable|date',
            'file_skck' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'tanggal_bnn' => 'nullable|date',
            'file_bnn' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'no_sim_a' => 'nullable|string|max:30',
            'masa_berlaku_sim' => 'nullable|date',
            'file_sim' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'jumlah_tilang_6_bulan' => 'nullable|integer|min:0',
            'no_kta' => 'nullable|string|max:30',
            'masa_berlaku_kta' => 'nullable|date',
            'file_kta' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'pangkat_garda' => 'nullable|in:pratama,madya,utama',
            'no_sertifikat_garda' => 'nullable|string|max:50',
            'file_sertifikat_garda' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif|max:2048',
        ]);

            

        $karyawan->update($validated);

        return back()->with('success', 'Profile berhasil diperbarui.');
    }

    /* ================= FORM LENGKAP ================= */

    public function form()
    {
        $karyawan = $this->getKaryawanOrFail();
        
        $unitpln = MasterUnitPln::all();
        $jabatan = Jabatan::all();
        $subunit = MasterSubUnit::all();
        $tad = MasterTad::all();
        $project = MasterProject::all();
        $pendidikan = MasterPendidikan::all();

        return view('karyawan.form', compact('karyawan', 'unitpln', 'jabatan', 'subunit', 'tad', 'project', 'pendidikan'));
    }

    public function updateAllSteps(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();

        $validated = $request->all();
        
        $fillable = $karyawan->getFillable();
        $data = array_filter($validated, function($key) use ($fillable) {
            return in_array($key, $fillable);
        }, ARRAY_FILTER_USE_KEY);

        $karyawan->update($data);
        $karyawan->update([
            'tanggal_input' => now(),
            'is_complete' => true
        ]);

        return redirect()->route('karyawan.dashboard')
            ->with('success', 'Semua data berhasil disimpan.');
    }
}



