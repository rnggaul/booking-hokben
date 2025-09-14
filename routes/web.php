<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;

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

Route::get('/', [AuthController::class, 'showLoginForm']); // default halaman login
Route::get('/login', [AuthController::class, 'showLoginForm']); // optional, biar /login juga ke login page
Route::post('/login', [AuthController::class, 'login'])->name('login'); // form submit

Route::get('/home', function () {
    return view('home');
})->name('home'); // halaman setelah login

Route::get('/booking', function () {
    return view('booking');
})->name('booking');

Route::get('/admin', function () {
    return view('admin');
})->name('admin');

Route::get('/booking', [BookingController::class, 'create']); // menampilkan form
Route::post('/booking', [BookingController::class, 'store']);  // menyimpan ke database
Route::get('/bookingdb/kalender', [BookingController::class, 'getKalender']);

