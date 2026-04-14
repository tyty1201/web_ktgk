<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/laptop/theloai/{id}', [App\Http\Controllers\HomeController::class, 'category']);

Route::get('/laptop/chitiet/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('laptop.show');

// Sửa lại dòng này trong routes/web.php
Route::get('/timkiem', [HomeController::class, 'search'])->name('laptop.search');
// Route xử lý thêm vào giỏ hàng (phương thức POST)
Route::post('/laptop/add-to-cart/{id}', [App\Http\Controllers\HomeController::class, 'addToCart'])->name('cart.add');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/account', function () {
        return view('account');
    })->name('account');
});

Route::get('/timkiem', [HomeController::class, 'search'])->name('search');

// ==================== CART ROUTES ====================
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
});


require __DIR__.'/auth.php';