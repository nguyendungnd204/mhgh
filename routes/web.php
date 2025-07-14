<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
})->name('home');

Route::middleware('guest')->group(function() {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
});


Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [AuthController::class, 'dashboard' ])->name('dashboard');
});

Route::middleware('auth', 'role:admin')->prefix('admin')->name('admin.')->group(function() {
    Route::get('dashboard', function () {
        return view('admin.dashboard');})->name('dashboard');


    Route::get('events', [EventController::class, 'index' ])->name('events.index');
    Route::post('events/store', [EventController::class, 'store' ])->name('events.store');
    Route::get('events/create', [EventController::class, 'create' ])->name('events.create');
    Route::get('events/{id}', [EventController::class, 'show'])->name('events.show');
    Route::get('events/edit/{id}', [EventController::class, 'edit'])->name('events.edit');
    Route::patch('events/update/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('events/delete/{id}', [EventController::class, 'destroy'])->name('events.destroy');


    Route::get('news', [NewsController::class, 'index'])->name('news.index');
    Route::get('news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('news', [NewsController::class, 'store'])->name('news.store');
    Route::get('news/{id}', [NewsController::class, 'show'])->name('news.show');

});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
     Route::get('dashboard', function () {
        return view('user.dashboard');})->name('dashboard');
});