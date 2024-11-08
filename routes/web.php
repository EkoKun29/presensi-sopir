<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PresensiPulangController;
use App\Http\Controllers\UserController;

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

Auth::routes();
Route::get('/log-in', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('_login');
Route::post('/log-in-post', [App\Http\Controllers\Auth\LoginController::class, 'posts'])->name('_postlogin');
//Logout
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('_logout');
Route::get('/', function () {
    return view('auth.login');
})->name('root-login');


Route::middleware(['auth'])->group(function () {

//-----------------------------------------------------------Absen Berangkat-----------------------------------------------------
Route::resource('presensi', PresensiController::class);
Route::get('presensi/search', [PresensiController::class, 'search'])->name('absensi.search');
Route::get('presensi/{nama}/{tanggal}', [PresensiController::class, 'show'])->name('presensi.show.detail');
Route::get('presensi/{nama}/{tanggal}/delete', [PresensiController::class, 'delete'])->name('presensi.delete.detail');

//-----------------------------------------------------------Absen Pulang-----------------------------------------------------
Route::resource('presensi-pulang', PresensiPulangController::class);
Route::get('presensi-pulang/search', [PresensiPulangController::class, 'search'])->name('absensi-pulang.search');
Route::get('presensi-pulang/{nama}/{tanggal}', [PresensiPulangController::class, 'show'])->name('presensi-pulang.show.detail');
Route::get('presensi-pulang/{nama}/{tanggal}/delete', [PresensiPulangController::class, 'delete'])->name('presensi-pulang.delete.detail');

//----------------------------------------------------------Tambah User--------------------------------------------
Route::resource('tambah-user', UserController::class);
Route::get('search', [UserController::class, 'search'])->name('user.search');
Route::get('tambah-user/{id}/delete', [UserController::class, 'delete'])->name('user.delete');

//Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});