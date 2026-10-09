<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Buyer;
use App\Http\Controllers\Store;
use Illuminate\Support\Facades\Route;

// Landing: send everyone to the right place.
Route::get('/', fn () => auth()->check()
    ? redirect()->route(auth()->user()->dashboardRoute())
    : redirect()->route('login'));

// Guests only
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
});

// Any logged-in user
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password');
});

// Store (seller) area
Route::middleware(['auth', 'role:store'])->prefix('store')->name('store.')->group(function () {
    Route::view('/dashboard', 'store.dashboard')->name('dashboard');

    Route::resource('produce', Store\ProduceController::class)->except('show');

    Route::get('/orders', [Store\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/export', [Store\OrderController::class, 'export'])->name('orders.export');
    Route::patch('/orders/{order}', [Store\OrderController::class, 'update'])->name('orders.update');
});

// Buyer area
Route::middleware(['auth', 'role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::view('/dashboard', 'buyer.dashboard')->name('dashboard');

    Route::get('/browse', [Buyer\BrowseController::class, 'index'])->name('browse');
    Route::get('/stores', [Buyer\StoreController::class, 'index'])->name('stores');
    Route::get('/prices', [Buyer\PriceController::class, 'index'])->name('prices');

    Route::get('/orders', [Buyer\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/export', [Buyer\OrderController::class, 'export'])->name('orders.export');
    Route::post('/orders', [Buyer\OrderController::class, 'store'])->name('orders.store');
    Route::patch('/orders/{order}/cancel', [Buyer\OrderController::class, 'cancel'])->name('orders.cancel');
});
