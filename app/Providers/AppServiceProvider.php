<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 1. Thêm 2 dòng này lên đầu file
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 2. Thêm đoạn này để chia sẻ biến $categories cho tất cả các file .blade.php
        if (!app()->runningInConsole()) {
            $categories = DB::table('danh_muc_laptop')->get();
            View::share('categories', $categories);
        }
    }
}