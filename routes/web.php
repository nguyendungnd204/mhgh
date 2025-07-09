<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('guest')->group(function() {
    Route::get('register', [UserController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [UserController::class, 'register'])->name('register');
    Route::post('login', [UserController::class, 'login']);
    Route::get('login', [UserController::class, 'showLoginForm'])->name('login');
});


Route::middleware('auth')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::get('dashboard', [UserController::class, 'dashboard' ])->name('dashboard');
});

Route::middleware('auth', 'role:admin')->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');})->name('dashboard');
});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
     Route::get('/dashboard', function () {
        return view('user.dashboard');})->name('dashboard');
});