<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Route::get('/', [HomeController::class, 'index'])->name('home');   // ← Quan trọng: thêm name('home')

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/account', function () {
        return view('account');   // tạm thời, sau bạn sẽ thay bằng controller
    })->name('account');
});

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