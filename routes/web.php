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
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// besok lanjut ke sub unit pln, ini agak susah karena relasi jadi besok aja aku dah tak kuat sakit nih mata 
// lanjut esok sekalian karyawan ini biar aku yang pegang.. anjayyy (*/ω＼*)

// login nih
Route::get('/',[AuthController::class,'showformlogin'])->name('auth.login');
Route::post('/login',[AuthController::class,'proseslogin'])->name('login.proses');
Route::get('/dashboard',[AuthController::class,'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

// user
Route::get('/user',[UserController::class,'index'])->name('users.index');
Route::get('/user/create',[UserController::class,'create'])->name('users.create');
Route::post('/user',[UserController::class,'store'])->name('users.store');
//Route::get('/user/{id}/edit',[UserController::class,'edit'])->name('users.edit');
//Route::put('user/{id}',[UserController::class,'update'])->name('users.update');
Route::delete('/user/{id}',[UserController::class,'destroy'])->name('users.destroy');

//master sub unit
Route::prefix('master-sub-unit')->group(function () {
Route::get('/', [MasterSubUnitController::class, 'index'])->name('master-sub-unit.index');
Route::get('/create', [MasterSubUnitController::class, 'create'])->name('master-sub-unit.create');
Route::post('/', [MasterSubUnitController::class, 'store'])->name('master-sub-unit.store');
Route::delete('/{id}', [MasterSubUnitController::class, 'destroy'])->name('master-sub-unit.destroy');
});


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
Route::delete('/komponen/{id}', [KomponenController::class, 'destroy'])->name('komponen.destroy'); 
Route::put('/komponen/{id}/aktif', [KomponenController::class, 'aktifkan'])->name('komponen.aktif');
Route::put('/komponen/{id}/nonaktif', [KomponenController::class, 'nonaktifkan'])->name('komponen.nonaktif');