<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
});
