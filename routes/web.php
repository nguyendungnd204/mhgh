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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('news', [HomeController::class, 'news'])->name('news');
Route::get('events', [HomeController::class, 'events'])->name('events');
Route::get('news/{id}', [HomeController::class, 'showNews'])->name('news.show');
Route::get('events/{id}', [HomeController::class, 'showEvent'])->name('events.show');

Route::middleware('guest')->group(function() {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('change-password', [AuthController::class, 'changePasswordForm'])->name('edit-password');
    Route::put('change-password', [AuthController::class, 'changePassword'])->name('update-password');

    Route::prefix('user')->name('user.')->group(function () {
        
        Route::middleware(['permission:create transactions'])->group(function () {
            Route::get('transaction', [TransactionController::class, 'transaction'])->name('transaction');
        });
        
        Route::middleware(['permission:view transactions user'])->group(function () {
            Route::get('history', [TransactionController::class, 'history'])->name('history');
        });
    });

    Route::prefix('admin')->name('admin.')->group(function() {
        
        Route::middleware(['permission:access manager dashboard'])->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        });

        Route::prefix('events')->name('events.')->group(function () {

            Route::middleware(['permission:create events'])->group(function () {
                Route::get('/create', [EventController::class, 'create'])->name('create');
                Route::post('/', [EventController::class, 'store'])->name('store');
            });
            
            Route::middleware(['permission:view events'])->group(function () {
                Route::get('/', [EventController::class, 'index'])->name('index');
                Route::get('/{id}', [EventController::class, 'show'])->name('show');
            });
            
            Route::middleware(['permission:edit events'])->group(function () {
                Route::get('/{id}/edit', [EventController::class, 'edit'])->name('edit');
                Route::patch('/{id}', [EventController::class, 'update'])->name('update');
            });
            
            Route::middleware(['permission:delete events'])->group(function () {
                Route::delete('/{id}', [EventController::class, 'destroy'])->name('destroy');
            });
        });

        Route::prefix('news')->name('news.')->group(function () {

            Route::middleware(['permission:create news'])->group(function () {
                Route::get('/create', [NewsController::class, 'create'])->name('create');
                Route::post('/', [NewsController::class, 'store'])->name('store');
            });
            
            Route::middleware(['permission:view news'])->group(function () {
                Route::get('/', [NewsController::class, 'index'])->name('index');
                Route::get('/{id}', [NewsController::class, 'show'])->name('show');
            });
            
            Route::middleware(['permission:edit news'])->group(function () {
                Route::get('/{id}/edit', [NewsController::class, 'edit'])->name('edit');
                Route::patch('/{id}', [NewsController::class, 'update'])->name('update');
            });
            

            // Route::middleware(['permission:delete news'])->group(function () {
            //     Route::delete('/{id}', [NewsController::class, 'destroy'])->name('destroy');
            // });
        });

        Route::prefix('users')->name('users.')->group(function () {

            Route::middleware(['permission:create users'])->group(function () {
                Route::get('/register', [AuthController::class, 'showCreateUserForm'])->name('register');
                Route::post('/create-user', [AuthController::class, 'createUser'])->name('create-user');
            });
            
            Route::middleware(['permission:view users'])->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/{id}', [UserController::class, 'show'])->name('show');
            });
            
            Route::middleware(['permission:edit users'])->group(function () {
                Route::patch('/{id}/status', [UserController::class, 'updateStatus'])->name('update-status');
            });
        });

        Route::prefix('giftcodes')->name('giftcodes.')->group(function () {

            Route::middleware(['permission:create giftcodes'])->group(function () {
                Route::get('/create', [GiftController::class, 'create'])->name('create');
                Route::post('/', [GiftController::class, 'store'])->name('store');
                // Route::get('/generate-code', [GiftController::class, 'generateCode'])->name('generate');
            });
            
            Route::middleware(['permission:view giftcodes'])->group(function () {
                Route::get('/', [GiftController::class, 'index'])->name('index');
                Route::get('/{id}', [GiftController::class, 'show'])->name('show');
            });
            
            Route::middleware(['permission:edit giftcodes'])->group(function () {
                Route::get('/{id}/edit', [GiftController::class, 'edit'])->name('edit');
                Route::patch('/{id}', [GiftController::class, 'update'])->name('update');
            });
            
            Route::middleware(['permission:delete giftcodes'])->group(function () {
                Route::delete('/{id}', [GiftController::class, 'destroy'])->name('destroy');
            });
        });

        Route::prefix('transactions')->name('transactions.')->group(function () {
            
            Route::middleware(['permission:view transactions'])->group(function () {
                Route::get('/', [TransactionController::class, 'index'])->name('index');
                Route::get('/{id}', [TransactionController::class, 'show'])->name('show');
            });
            
            Route::middleware(['permission:edit transactions'])->group(function () {
                Route::patch('/{id}/status', [TransactionController::class, 'updateStatus'])->name('update-status');
            });
        });

        Route::middleware(['permission:access manager dashboard'])->group(function () {
            Route::get('manager-dashboard', [DashboardController::class, 'managerDashboard'])->name('manager.dashboard');
        });
    });

});