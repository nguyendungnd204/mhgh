<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home.index');
// })->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('news', [HomeController::class, 'news'])->name('news');
Route::get('events', [HomeController::class, 'events'])->name('events');
Route::get('news/{id}', [HomeController::class, 'showNews'])->name('news.show');
Route::get('events/{id}', [HomeController::class, 'showEvent'])->name('events.show');

Route::middleware('guest')->group(function() {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    
});


Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [AuthController::class, 'dashboard' ])->name('dashboard');
    Route::get('change-password', [AuthController::class, 'changePasswordForm'])->name('edit-password');
    Route::put('change-password', [AuthController::class, 'changePassword'])->name('update-password');
});

Route::middleware('auth', 'role:admin')->prefix('admin')->name('admin.')->group(function() {
    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('register', [AuthController::class, 'showCreateUserForm'])->name('register');

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
    Route::patch('users/{id}/status', [UserController::class, 'updateStatus'])->name('users.update-status');
    Route::post('/create-user', [AuthController::class, 'createUser'])->name('users.create-user');


    Route::get('giftcodes', [GiftController::class, 'index'])->name('giftcodes.index');
    Route::get('giftcodes/create', [GiftController::class, 'create'])->name('giftcodes.create');
    Route::get('/giftcodes/{id}', [GiftController::class, 'show'])->name('giftcodes.show');
    Route::post('giftcodes', [GiftController::class, 'store'])->name('giftcodes.store');
    // Route::get('giftcodes/generate-code', [GiftController::class, 'generateCode'])->name('giftcodes.generate');
    Route::get('giftcodes/{id}/edit', [GiftController::class, 'edit'])->name('giftcodes.edit');
    Route::patch('giftcodes/{id}', [GiftController::class, 'update'])->name('giftcodes.update');


    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::patch('transactions/{id}/status', [TransactionController::class, 'updateStatus'])->name('transactions.update-status');
    Route::get('transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');

});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    Route::get('transaction', [TransactionController::class, 'transaction'])->name('transaction');
    Route::get('history', [TransactionController::class, 'history'])->name('history');
});