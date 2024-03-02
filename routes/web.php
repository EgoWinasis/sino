<?php

use App\Http\Controllers\CetakController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MapsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerifikasiController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// users
Route::resource('user', UserController::class);
// profile
Route::resource('profile', ProfileController::class);
// cuti
Route::group(['middleware' => 'profile.check'], function () {
    // Routes that require profile check
    Route::resource('customer', CustomerController::class);
    Route::resource('verifikasi', VerifikasiController::class);
    Route::resource('cetak', CetakController::class);
    Route::resource('maps', MapsController::class);
    
    
});
