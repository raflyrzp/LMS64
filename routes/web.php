<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelajaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Login
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'login']);

//Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'userAkses:admin'])->group(function () {
});
Route::middleware(['auth', 'userAkses:guru'])->group(function () {
});
Route::middleware(['auth', 'userAkses:siswa'])->group(function () {
    Route::get('/siswa', [DashboardController::class, 'siswaIndex'])->name('siswa.index');
    Route::post('/siswa', [KelasController::class, 'joinKelas'])->name('join.kelas');

    Route::get('/siswa/{pelajaran}/{id}', [PelajaranController::class, 'index'])->name('siswa.pelajaran');
});
