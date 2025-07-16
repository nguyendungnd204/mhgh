<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\UserController;
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
    Route::get('events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::patch('events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('events/{id}', [EventController::class, 'destroy'])->name('events.destroy');


    Route::get('news', [NewsController::class, 'index'])->name('news.index');
    Route::get('news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('news', [NewsController::class, 'store'])->name('news.store');
    Route::get('news/{id}', [NewsController::class, 'show'])->name('news.show');
    Route::get('news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::patch('news/{id}', [NewsController::class, 'update'])->name('news.update');


    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::patch('users/{id}/status', [UserController::class, 'updateStatus'])->name('users.updateStatus');

    Route::get('giftcode', [GiftController::class, 'index'])->name('giftcode.index');
    Route::get('/giftCode/{id}', [GiftController::class, 'show'])->name('giftcode.show');

});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    Route::get('transaction', [UserController::class, 'transaction'])->name('transaction');
    Route::get('history', [UserController::class, 'history'])->name('history');
});