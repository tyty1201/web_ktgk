<?php

use App\Http\Controllers\HomeController;
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



require __DIR__.'/auth.php';
