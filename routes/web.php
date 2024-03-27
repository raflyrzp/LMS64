<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MateriController;
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
    Route::get('/guru', [DashboardController::class, 'guruIndex'])->name('guru.index');
    Route::post('/guru/pelajaran', [PelajaranController::class, 'store'])->name('pelajaran.store');
    Route::put('/guru/pelajaran/{id}', [PelajaranController::class, 'update'])->name('pelajaran.update');
    Route::delete('/guru/pelajaran/{id}', [PelajaranController::class, 'destroy'])->name('pelajaran.destroy');

    Route::get('/guru/{pelajaran}', [MateriController::class, 'guruIndex'])->name('guru.materi');
    Route::get('/guru/{pelajaran}/{idMateri}', [MateriController::class, 'show'])->name('materi.show');

    Route::put('/guru/{pelajaran}/{idMateri}', [MateriController::class, 'editMateri'])->name('materi.edit');
    Route::delete('/guru/{pelajaran}/{idMateri}', [MateriController::class, 'destroy'])->name('materi.destroy');
    Route::delete('/guru/{pelajaran}/{idMateri}/{idFile}', [MateriController::class, 'deleteFile'])->name('file.delete');
});
Route::middleware(['auth', 'userAkses:siswa'])->group(function () {
    Route::get('/siswa', [DashboardController::class, 'siswaIndex'])->name('siswa.index');
    Route::post('/siswa', [KelasController::class, 'joinKelas'])->name('join.kelas');

    Route::get('/siswa/{pelajaran}', [MateriController::class, 'siswaIndex'])->name('siswa.materi');
    Route::get('/siswa/{idPelajaran}/{idMateri}', [MateriController::class, 'siswaShow'])->name('siswa.materi.show');
});
