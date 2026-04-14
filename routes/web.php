<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Danh mục và chi tiết sản phẩm
Route::get('/laptop/theloai/{id}', [HomeController::class, 'category']);
Route::get('/laptop/chitiet/{id}', [HomeController::class, 'show'])->name('laptop.show');

// Tìm kiếm
Route::get('/timkiem', [HomeController::class, 'search'])->name('search');

// ==================== CART ROUTES ====================
Route::prefix('gio-hang')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
    Route::delete('/delete/{id}', [CartController::class, 'delete'])->name('delete');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
});

// Dashboard & Profile
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/account', function () {
        return view('account');
    })->name('account');
});

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products');
    Route::post('/products/delete/{id}', [ProductController::class, 'softDelete'])->name('products.delete');
});

// ==================== KIỂM TRA DATABASE ====================
Route::get('/kiem-tra-db', function () {
    $dbName = DB::connection()->getDatabaseName();
    $hasColumn = Schema::hasColumn('san_pham', 'status');

    if (!$hasColumn) {
        DB::statement('ALTER TABLE san_pham ADD COLUMN status TINYINT DEFAULT 1');
        return "<h1>THÀNH CÔNG!</h1> 
                <p>Đã thêm cột 'status' vào bảng 'san_pham' của database: <b>" . $dbName . "</b></p> 
                <a href='/admin/products'>Quay lại trang quản lý</a>";
    }

    return "<h1>ĐÃ CÓ CỘT STATUS!</h1> 
            <p>Database hiện tại là: <b>" . $dbName . "</b></p> 
            <a href='/admin/products'>Quay lại trang quản lý</a>";
});

require __DIR__.'/auth.php';