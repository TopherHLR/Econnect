<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//---------------------------------------------------- AUTH -------------------------------------------------
// Sign up routes
Route::get('/signup', [AuthController::class, 'showRegisterForm'])->name('signup');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Example home route (redirect destination)
Route::get('/', function () {
    return view('home'); // create home.blade.php later
})->name('home');
//---------------------------------------------------- AUTH -------------------------------------------------