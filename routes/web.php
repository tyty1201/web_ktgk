<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
<<<<<<< HEAD
=======
use App\Http\Controllers\CartController;
>>>>>>> 6deb0b5a0116a57f8900d46681257d6d250a0be8
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

<<<<<<< HEAD
Route::get('/', [HomeController::class, 'index'])->name('home');   // ← Quan trọng: thêm name('home')
=======
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/laptop/theloai/{id}', [App\Http\Controllers\HomeController::class, 'category']);

Route::get('/laptop/chitiet/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('laptop.show');

// Sửa lại dòng này trong routes/web.php
Route::get('/timkiem', [HomeController::class, 'search'])->name('laptop.search');
// Route xử lý thêm vào giỏ hàng (phương thức POST)
Route::post('/laptop/add-to-cart/{id}', [App\Http\Controllers\HomeController::class, 'addToCart'])->name('cart.add');
>>>>>>> 6deb0b5a0116a57f8900d46681257d6d250a0be8

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
<<<<<<< HEAD
=======

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
>>>>>>> 6deb0b5a0116a57f8900d46681257d6d250a0be8

    Route::get('/account', function () {
        return view('account');   // tạm thời, sau bạn sẽ thay bằng controller
    })->name('account');
});

<<<<<<< HEAD
require __DIR__.'/auth.php';

// Hiển thị trang quản lý
Route::get('/admin/products', [ProductController::class, 'adminIndex'])->name('admin.products');

// Xử lý xóa mềm
Route::post('/admin/products/delete/{id}', [ProductController::class, 'softDelete'])->name('admin.products.delete');

Route::get('/kiem-tra-db', function() {
    $dbName = DB::connection()->getDatabaseName(); // Lấy tên DB Laravel đang dùng
    $hasColumn = Schema::hasColumn('san_pham', 'status'); // Kiểm tra xem có cột status chưa

    if (!$hasColumn) {
        // Nếu chưa có, ép thêm vào
        DB::statement('ALTER TABLE san_pham ADD COLUMN status TINYINT DEFAULT 1');
        return "<h1>THÀNH CÔNG!</h1> <p>Đã thêm cột 'status' vào bảng 'san_pham' của database: <b>" . $dbName . "</b></p> <a href='/admin/products'>Quay lại trang quản lý</a>";
    }

    return "<h1>ĐÃ CÓ CỘT STATUS!</h1> <p>Database hiện tại là: <b>" . $dbName . "</b></p> <a href='/admin/products'>Quay lại trang quản lý</a>";
});
=======
require __DIR__.'/auth.php';
>>>>>>> 6deb0b5a0116a57f8900d46681257d6d250a0be8
