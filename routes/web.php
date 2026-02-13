<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\KomponenController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\MasterJabatanController;
use App\Http\Controllers\MasterProjectController;
use App\Http\Controllers\MasterPendidikanController;
use App\Http\Controllers\MasterTadController;
use App\Http\Controllers\MasterUnitPlnController;
use App\Http\Controllers\MasterSubUnitController;
use App\Http\Controllers\MasterKerjaSamaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AbsensiController;
//
use App\Http\Controllers\KaryawanController;

// login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('forgot');
Route::post('/forgot-password', [AuthController::class, 'sendReset'])->name('forgot.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// dashboard
Route::middleware('auth')->group(function () {
Route::get('/superadmin/dashboard', function () {return view('superadmin.dashboard'); });
Route::get('/admin/dashboard', function () {return view('admin.dashboard');});
Route::get('/karyawan/dashboard', function () {return view('karyawan.dashboard');});
});


// karyawan
Route::middleware(['auth'])->prefix('karyawan')->name('karyawan.')->group(function () {
Route::get('step1', [KaryawanController::class,'step1'])->name('step1');
Route::post('step1', [KaryawanController::class,'storestep1'])->name('store.step1');
Route::get('step2', [KaryawanController::class,'step2'])->name('step2');
Route::post('step2', [KaryawanController::class,'storestep2'])->name('store.step2');
Route::get('step3', [KaryawanController::class,'step3'])->name('step3');
Route::post('step3', [KaryawanController::class,'storestep3'])->name('store.step3');
Route::get('step4', [KaryawanController::class,'step4'])->name('step4');
Route::post('step4', [KaryawanController::class,'storestep4'])->name('store.step4');
Route::get('step5', [KaryawanController::class,'step5'])->name('step5');
Route::post('step5', [KaryawanController::class,'storestep5'])->name('store.step5');
Route::get('step6', [KaryawanController::class,'step6'])->name('step6');
Route::post('step6', [KaryawanController::class,'storestep6'])->name('store.step6');
Route::get('step7', [KaryawanController::class,'step7'])->name('step7');
Route::post('step7', [KaryawanController::class,'storestep7'])->name('store.step7');
Route::get('step8', [KaryawanController::class,'step8'])->name('step8');
Route::post('step8', [KaryawanController::class,'storestep8'])->name('store.step8');
Route::get('step9', [KaryawanController::class,'step9'])->name('step9');
Route::post('step9', [KaryawanController::class,'storestep9'])->name('store.step9');
Route::get('step10', [KaryawanController::class,'step10'])->name('step10');
Route::post('step10', [KaryawanController::class,'storestep10'])->name('store.step10');
Route::get('khusus', [KaryawanController::class,'stepKhusus'])->name('stepkhusus');
Route::post('khusus', [KaryawanController::class,'storestepkhusus'])->name('store.stepkhusus');
Route::get('finish', [KaryawanController::class,'finish'])->name('finish');
Route::get('dashboard', [KaryawanController::class,'dashboard'])->name('dashboard');
});

// user
Route::get('/user',[UserController::class,'index'])->name('users.index');
Route::get('/user/create',[UserController::class,'create'])->name('users.create');
Route::post('/user',[UserController::class,'store'])->name('users.store');
//Route::get('/user/{id}/edit',[UserController::class,'edit'])->name('users.edit');
//Route::put('user/{id}',[UserController::class,'update'])->name('users.update');
Route::delete('/user/{id}',[UserController::class,'destroy'])->name('users.destroy');

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
Route::get('/penggajian/{id}/edit', [PenggajianController::class, 'edit'])->name('penggajian.edit');
Route::put('/penggajian/{id}', [PenggajianController::class, 'update'])->name('penggajian.update');
Route::delete('/penggajian/{id}', [PenggajianController::class, 'destroy'])->name('penggajian.destroy');

//KOMPONEN GAJI
Route::get('/komponen', [KomponenController::class, 'index'])->name('komponen.index');
Route::get('/komponen/create', [KomponenController::class, 'create'])->name('komponen.create');
Route::post('/komponen', [KomponenController::class, 'store'])->name('komponen.store');
Route::get('/komponen/{id}/edit', [KomponenController::class, 'edit'])->name('komponen.edit');
Route::put('/komponen/{id}', [KomponenController::class, 'update'])->name('komponen.update');
Route::put('/komponen/{id}/aktif', [KomponenController::class, 'aktifkan'])->name('komponen.aktif');
Route::put('/komponen/{id}/nonaktif', [KomponenController::class, 'nonaktifkan'])->name('komponen.nonaktif');
Route::delete('/komponen/{id}', [KomponenController::class, 'destroy'])->name('komponen.destroy');



//ABSENSI
Route::prefix('absensi')->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/store', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::post('/pulang/{id}', [AbsensiController::class, 'pulang'])->name('absensi.pulang');
});

//kantor
Route::resource('kantor', KantorController::class);
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');;
Route::post('/face/scan', [AbsensiController::class, 'scanFace'])->name('face.scan');