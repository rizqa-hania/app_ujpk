<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\KomponenController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\MasterJabatanController;
use App\Http\Controllers\MasterProjectController;

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