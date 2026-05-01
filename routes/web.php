<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\KomponenController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\MasterJabatanController;
use App\Http\Controllers\MasterProjectController;
use App\Http\Controllers\MasterPendidikanController;
use App\Http\Controllers\MasterTadController;
use App\Http\Controllers\MasterUnitPlnController;
use App\Http\Controllers\MasterSubUnitController;
use App\Http\Controllers\MasterKerjaSamaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KantorController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\Admin\JadwalAbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeriodeKaryawanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboard;
use App\Http\Controllers\SlipKaryawanController;
use App\Http\Controllers\UcapanController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;

//kirim ucapan
Route::post('/kirimucapan', [UcapanController::class, 'kirim']);
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'is_admin']], function() {
    
    // URL unik agar tidak disangka ID oleh route DELETE
    Route::get('/monitoring-presensi', [AbsensiController::class, 'monitoring'])->name('admin.absensi.monitoring');
    
    // dihapus duplicated route

    // Resource lainnya di bawah
    Route::resource('absensi', 'AbsensiController');
});

//COBA EMAIL
Route::get('/test-mail', function () {

    Mail::raw('Ini email test dari Laravel', function ($message) {
        $message->to('muhammadikhwan@gmail.com')->subject('Test Email Laravel');
    });

    return "Email berhasil dikirim!";
});




Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {

    $googleUser = Socialite::driver('google')->user();

    $user = User::updateOrCreate(
        ['email' => $googleUser->email],
        [
            'name' => $googleUser->name,
            'password' => bcrypt('google_login'),
            'is_verified' => true
        ]
    );

    Auth::login($user);

    return redirect('/dashboard');
});
// ucapan
// tambah admin 
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
Route::delete('/admin/{Id}', [AdminController::class, 'destroy'])->name('admin.destroy');


// Auth
Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::get('/', function() { return redirect()->route('login'); });
Route::post('/login', [AuthController::class,'login'])->name('login.process');
Route::get('/register', [AuthController::class,'showRegister'])->name('register');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send-otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp');
Route::post('/complete-register', [AuthController::class, 'completeRegister'])->name('complete-register');
Route::delete('/logout', [AuthController::class,'logout'])->name('logout');
// Admin Dashboard
Route::prefix('admin')->middleware(['auth','is_admin'])->group(function(){
    Route::get('/dashboard', [AdminDashboard::class,'index'])->name('admin.dashboard');
    Route::get('/karyawan', [AdminController::class, 'karyawanIndex'])->name('admin.karyawan.index');
    Route::get('/karyawan/{id}', [AdminController::class, 'karyawanShow'])->name('admin.karyawan.show');
});

 // tambah karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.tambah.index');
    Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.tambah.create');
    Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('karyawan.tambah.store');
    Route::delete('/karyawan/{Id}', [KaryawanController::class, 'destroy'])->name('karyawan.tambah.destroy');

//karyawan
Route::prefix('karyawan')->name('karyawan.')->middleware(['auth'])->group(function () {

    // Dashboard pakai middleware check profile
    Route::get('/dashboard', [KaryawanController::class, 'dashboard'])
        ->name('dashboard')
        ->middleware('check.profile.complete');

    // Step-step input data karyawan
    Route::get('/step1', [KaryawanController::class, 'step1'])->name('step1');
    Route::post('/step1', [KaryawanController::class, 'storestep1'])->name('storestep1');

    Route::get('/step2', [KaryawanController::class, 'step2'])->name('step2');
    Route::post('/step2', [KaryawanController::class, 'storestep2'])->name('storestep2');

    Route::get('/step3', [KaryawanController::class, 'step3'])->name('step3');
    Route::post('/step3', [KaryawanController::class, 'storestep3'])->name('storestep3');

    Route::get('/step4', [KaryawanController::class, 'step4'])->name('step4');
    Route::post('/step4', [KaryawanController::class, 'storestep4'])->name('storestep4');

    Route::get('/step5', [KaryawanController::class, 'step5'])->name('step5');
    Route::post('/step5', [KaryawanController::class, 'storestep5'])->name('storestep5');

    Route::get('/step6', [KaryawanController::class, 'step6'])->name('step6');
    Route::post('/step6', [KaryawanController::class, 'storestep6'])->name('storestep6');

    Route::get('/step7', [KaryawanController::class, 'step7'])->name('step7');
    Route::post('/step7', [KaryawanController::class, 'storestep7'])->name('storestep7');

    Route::get('/step8', [KaryawanController::class, 'step8'])->name('step8');
    Route::post('/step8', [KaryawanController::class, 'storestep8'])->name('storestep8');

    Route::get('/step9', [KaryawanController::class, 'step9'])->name('step9');
    Route::post('/step9', [KaryawanController::class, 'storestep9'])->name('storestep9');

    Route::get('/step10', [KaryawanController::class, 'step10'])->name('step10');
    Route::post('/step10', [KaryawanController::class, 'storestep10'])->name('storestep10');

    Route::get('/step11', [KaryawanController::class, 'step11'])->name('step11');
    Route::post('/step11', [KaryawanController::class, 'storestep11'])->name('storestep11');

    // Profile
    Route::get('/profile', [KaryawanController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [KaryawanController::class, 'updateProfile'])->name('profile.update');
    
    // Optional finish route, biasanya nggak dipakai langsung
    Route::get('/finish', [KaryawanController::class, 'finish'])->name('finish');

});


//DASHBOARD SEMUANYA
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//master sub unit
Route::get('/sub', [MasterSubUnitController::class, 'index'])->name('master-sub-unit.index');
Route::get('/sub/create', [MasterSubUnitController::class, 'create'])->name('master-sub-unit.create');
Route::post('/sub', [MasterSubUnitController::class, 'store'])->name('master-sub-unit.store');
Route::delete('/sub/{id}', [MasterSubUnitController::class, 'destroy'])->name('master-sub-unit.destroy');

//master kerjasama
Route::prefix('master-kerja-sama')->group(function () {
Route::get('/', [MasterKerjaSamaController::class, 'index'])->name('master-kerja-sama.index');
Route::get('/create', [MasterKerjaSamaController::class, 'create'])->name('master-kerja-sama.create');
Route::post('/', [MasterKerjaSamaController::class, 'store'])->name('master-kerja-sama.store');
Route::delete('/{id}', [MasterKerjaSamaController::class, 'destroy'])->name('master-kerja-sama.destroy');
});

// master unit pln
Route::get('/masterunitpln',[MasterUnitPlnController::class,'index'])->name('master_unit_pln.index');
Route::get('/masterunitpln/create',[MasterUnitPlnController::class,'create'])->name('master_unit_pln.create');
Route::post('/masterunitpln',[MasterUnitPlnController::class,'store'])->name('master_unit_pln.store');
Route::delete('/masterunitpln/{id}',[MasterUnitPlnController::class,'destroy'])->name('master_unit_pln.destroy');

// master tad
Route::get('/mastertad',[MasterTadController::class,'index'])->name('master_tad.index');
Route::get('/mastertad/create',[MasterTadController::class,'create'])->name('master_tad.create');
Route::post('/mastertad',[MasterTadController::class,'store'])->name('master_tad.store');
Route::delete('/mastertad/{id}',[MasterTadController::class,'destroy'])->name('master_tad.destroy');

// master pendidikan
Route::get('/masterpendidikan',[MasterPendidikanController::class,'index'])->name('master_pendidikan.index');
Route::get('/masterpendidikan/create',[MasterPendidikanController::class,'create'])->name('master_pendidikan.create');
Route::post('/masterpendidikan',[MasterPendidikanController::class,'store'])->name('master_pendidikan.store');
Route::delete('/masterpendidikan/{id}',[MasterPendidikanController::class,'destroy'])->name('master_pendidikan.destroy');

// master project
Route::get('/masterproject',[MasterProjectController::class,'index'])->name('master_project.index');
Route::get('/masterproject/create',[MasterProjectController::class,'create'])->name('master_project.create');
Route::post('/masterproject',[MasterProjectController::class,'store'])->name('master_project.store');
Route::delete('/masterproject/{id}',[MasterProjectController::class,'destroy'])->name('master_project.destroy');

// master jabatan
Route::get('/masterjabatan', [MasterJabatanController::class, 'index'])->name('master_jabatan.index');
Route::get('/masterjabatan/create', [MasterJabatanController::class, 'create'])->name('master_jabatan.create');
Route::post('/masterjabatan', [MasterJabatanController::class, 'store'])->name('master_jabatan.store');
Route::delete('/masterjabatan/{id}',[MasterJabatanController::class,'destroy'])->name('master_jabatan.destroy');

// LEMBUR
Route::middleware(['auth'])->group(function() {

    Route::get('lembur', [LemburController::class, 'index'])->name('lembur.index');
    Route::get('lembur/create', [LemburController::class, 'create'])->name('lembur.create');
    Route::post('lembur/store', [LemburController::class, 'store'])->name('lembur.store');
    Route::post('/lembur/{id}/approve', [LemburController::class, 'approve'])->name('lembur.approve');
    Route::post('/lembur/{id}/reject', [LemburController::class, 'reject'])->name('lembur.reject');
});

// LAPORAN
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/filter', [LaporanController::class, 'filter'])->name('report.filter');
Route::post('/laporan/generate', [LaporanController::class, 'generatePDF'])->name('report.generate');
Route::get('/laporan/transaksi/{id}', [LaporanController::class, 'generatePDFByTransaksi'])->name('laporan.generateid');


// Group Route untuk user yang sudah login
Route::middleware(['auth'])->group(function () {

    // --- ROUTE UTAMA (Dynamic Index) ---
    // Route ini otomatis nampilin view beda lewat logic if/else di Controller index()
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');

    // --- ROUTE KHUSUS KARYAWAN (Proses Absen) ---
    Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');

    // --- ROUTE KHUSUS ADMIN (Monitoring & Management) ---
    // Kita bungkus lagi pakai middleware role (opsional, tapi disarankan)
    Route::get('/absensi/monitoring', [AbsensiController::class, 'monitoring'])->name('absensi.monitoring');
    Route::get('/absensi/cetak-rekap', [AbsensiController::class, 'cetakRekap'])->name('absensi.rekap.cetak');
    // Route untuk halaman Scan Wajah (Index)
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.create');

// Route untuk halaman Rekap/Riwayat Karyawan (Tabel)
Route::get('/absensi/rekap', [AbsensiController::class, 'rekapKaryawan'])->name('absensi.rekap');
    
});

//kantor
Route::resource('kantor', KantorController::class);
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');
Route::post('/face/scan', [AbsensiController::class, 'scanFace'])->name('face.scan');

/*
=========================
IZIN
=========================
*/


//JADWAL ABSENSI
Route::get('/jadwal-absensi', [JadwalAbsensiController::class, 'index'])->name('jadwal.index');
Route::post('/jadwal-absensi/update', [JadwalAbsensiController::class, 'update'])->name('jadwal.update');
Route::middleware(['auth'])->group(function(){

    // CRUD Izin
    Route::get('izin', [IzinController::class, 'index'])->name('izin.index');
    Route::get('izin/create', [IzinController::class, 'create'])->name('izin.create');
    Route::post('izin', [IzinController::class, 'store'])->name('izin.store');
    Route::get('izin/{id}/edit', [IzinController::class, 'edit'])->name('izin.edit');
    Route::put('izin/{id}', [IzinController::class, 'update'])->name('izin.update');
    Route::delete('izin/{id}', [IzinController::class, 'destroy'])->name('izin.destroy');
    Route::post('/izin/{id}/approve', [IzinController::class, 'approve'])->name('izin.approve');
    Route::post('/izin/{id}/reject', [IzinController::class, 'reject'])->name('izin.reject');
});




// ROUTE BAGIAN PENGGAJIAN 
// PERIODE PENGGAJIAN ADMIN
Route::get('/penggajian', [PenggajianController::class, 'index'])->name('penggajian.index');
Route::get('/penggajian/create', [PenggajianController::class, 'create'])->name('penggajian.create');
Route::get('/penggajian/{id}/edit', [PenggajianController::class, 'edit'])->name('penggajian.edit');
Route::put('/penggajian/{id}', [PenggajianController::class, 'update'])->name('penggajian.update');
Route::post('/penggajian', [PenggajianController::class, 'store'])->name('penggajian.store');
Route::delete('/penggajian/{id}', [PenggajianController::class, 'destroy'])->name('penggajian.destroy');

// PERIODE KARYAWAN
Route::get('/periode', [PeriodeKaryawanController::class, 'index'])->name('periode_karyawan.index');
Route::get('/slip_karyawan', [SlipKaryawanController::class, 'index'])->name('slip_karyawan.index');
Route::get('/slip_karyawan/{id}', [SlipKaryawanController::class, 'show'])->name('slip_karyawan.show');
Route::get('/slip_karyawan/{id}/pdf', [SlipKaryawanController::class, 'downloadPdf'])->name('slip_karyawan.pdf');

// KOMPONEN GAJI
Route::get('/komponen', [KomponenController::class, 'index'])->name('komponen.index');
Route::get('/komponen/create', [KomponenController::class, 'create'])->name('komponen.create');
Route::post('/komponen', [KomponenController::class, 'store'])->name('komponen.store');
Route::get('/komponen/{kode}/edit', [KomponenController::class, 'edit'])->name('komponen.edit');
Route::put('/komponen/{kode}', [KomponenController::class, 'update'])->name('komponen.update');
Route::put('/komponen/{id}/aktif', [KomponenController::class, 'aktifkan'])->name('komponen.aktif');
Route::put('/komponen/{id}/nonaktif', [KomponenController::class, 'nonaktifkan'])->name('komponen.nonaktif');
Route::post('/komponen/import', [KomponenController::class, 'import'])->name('komponen.import');
Route::delete('/komponen/{id}', [KomponenController::class, 'destroy'])->name('komponen.destroy');

// DETAIL GAJI
Route::get('/penggajian/{id}/detail', [DetailController::class, 'index'])->name('detail.index');
Route::get('/penggajian/{id}/detail/create', [DetailController::class, 'create'])->name('detail.create');
Route::post('/penggajian/{id}/detail', [DetailController::class, 'store'])->name('detail.store');
Route::get('/detail/{id}/slip', [DetailController::class, 'show'])->name('detail.show');
Route::get('/detail/{id}/pdf', [DetailController::class, 'downloadPdf'])->name('slip.pdf');
Route::delete('/detail/{id}', [DetailController::class, 'destroy'])->name('detail.destroy');