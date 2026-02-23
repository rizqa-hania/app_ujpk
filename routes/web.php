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
use App\Http\Controllers\KaryawanController;
//
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboard;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {

    $googleUser = Socialite::driver('google')->user();

    $user = \App\Models\User::updateOrCreate(
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

// tambah admin 
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

// login


// Auth
Route::get('/', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login.process');
Route::get('/register', [AuthController::class,'showRegister'])->name('register');
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/complete-register', [AuthController::class, 'completeRegister']);
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

// Admin Dashboard
Route::prefix('admin')->middleware(['auth','is_admin'])->group(function(){
    Route::get('/dashboard', [AdminDashboard::class,'index'])->name('admin.dashboard');
});

// Karyawan Dashboard
Route::prefix('karyawan')->middleware(['auth','is_karyawan'])->group(function(){
    Route::get('/dashboard', [KaryawanDashboard::class,'index'])->name('karyawan.dashboard');
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



// master unit pln YEYYYY sisa satuu that simple, yang waras ya yang waras 
Route::get('/masterunitpln',[MasterUnitPlnController::class,'index'])->name('master_unit_pln.index');
Route::get('/masterunitpln/create',[MasterUnitPlnController::class,'create'])->name('master_unit_pln.create');
Route::post('/masterunitpln',[MasterUnitPlnController::class,'store'])->name('master_unit_pln.store');
Route::delete('/masterunitpln/{id}',[MasterUnitPlnController::class,'destroy'])->name('master_unit_pln.destroy');


// master tad anjay dah empattttt yeyyy 2 lagi, oke disini eror lagiiii dah ah cape that simple(👉ﾟヮﾟ)👉
Route::get('/mastertad',[MasterTadController::class,'index'])->name('master_tad.index');
Route::get('/mastertad/create',[MasterTadController::class,'create'])->name('master_tad.create');
Route::post('/mastertad',[MasterTadController::class,'store'])->name('master_tad.store');
Route::delete('/mastertad/{id}',[MasterTadController::class,'destroy'])->name('master_tad.destroy');

// master pendidikan ijikkk dah 3 nih dalam sehari, yang ini eror muluu kapan bisa selesaiin semua create dalam seharii (；′⌒`)
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
//Route::get('/masterjabatan-all', [MasterJabatanController::class, 'indexAll'])->name('master_jabatan.all');
Route::get('/masterjabatan/create', [MasterJabatanController::class, 'create'])->name('master_jabatan.create');
//Route::patch('/masterjabatan/{id}/status', [MasterJabatanController::class, 'toggleStatus'])->name('master_jabatan.status');
Route::post('/masterjabatan', [MasterJabatanController::class, 'store'])->name('master_jabatan.store');
// ini edit Route::get('/masterjabatan/{id}/edit', [MasterJabatanController::class, 'edit'])->name('master_jabatan.edit');
//Route::put('/masterjabatan/{id}', [MasterJabatanController::class, 'update'])->name('master_jabatan.update');
Route::delete('/masterjabatan/{id}',[MasterJabatanController::class,'destroy'])->name('master_jabatan.destroy');




//LEMBUR
Route::get('/lembur', [LemburController::class, 'index'])->name('lembur.index');
Route::get('/lembur/create', [LemburController::class, 'create'])->name('lembur.create');
Route::post('/lembur', [LemburController::class, 'store'])->name('lembur.store');
Route::put('/lembur/{lembur}/status', [LemburController::class, 'updateStatus'])->name('lembur.status');

// PENGGAJIAN
Route::get('/penggajian', [PenggajianController::class, 'index'])->name('penggajian.index');
Route::get('/penggajian/create', [PenggajianController::class, 'create'])->name('penggajian.create');
Route::post('/penggajian', [PenggajianController::class, 'store'])->name('penggajian.store');
Route::delete('/penggajian/{id}', [PenggajianController::class, 'destroy'])->name('penggajian.destroy');

// KOMPONEN GAJI
Route::get('/komponen', [KomponenController::class, 'index'])->name('komponen.index');
Route::get('/komponen/create', [KomponenController::class, 'create'])->name('komponen.create');
Route::post('/komponen', [KomponenController::class, 'store'])->name('komponen.store');
Route::put('/komponen/{id}/aktif', [KomponenController::class, 'aktifkan'])->name('komponen.aktif');
Route::put('/komponen/{id}/nonaktif', [KomponenController::class, 'nonaktifkan'])->name('komponen.nonaktif');
Route::delete('/komponen/{id}', [KomponenController::class, 'destroy'])->name('komponen.destroy');

// DETAIL GAJI
Route::get('/penggajian/{id}/detail', [DetailController::class, 'index'])->name('detail.index');
Route::get('/penggajian/{id}/detail/create', [DetailController::class, 'create'])->name('detail.create');
Route::post('/penggajian/{id}/detail', [DetailController::class, 'store'])->name('detail.store');
Route::get('/detail/{id}/slip', [DetailController::class, 'show'])->name('detail.show');


//ABSENSI
Route::middleware(['auth'])->group(function(){
    Route::get('/absensi','AbsensiController@index')->name('absensi.index');
    Route::post('/absensi','AbsensiController@store')->name('absensi.store');

});


//kantor
Route::resource('kantor', KantorController::class);
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');;
Route::post('/face/scan', [AbsensiController::class, 'scanFace'])->name('face.scan');
