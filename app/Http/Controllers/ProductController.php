<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Yêu cầu 7: Hiển thị trang quản lý sản phẩm [cite: 21, 22]
    public function adminIndex()
    {
        $products = \Illuminate\Support\Facades\DB::table('san_pham')->where('status', 1)->get();
        return view('admin.products', compact('products'));
    }

    // Yêu cầu 7: Thực hiện xóa mềm sản phẩm [cite: 23]
    public function softDelete($id)
    {
        // Cập nhật cột status thành 0 thay vì xóa bản ghi [cite: 23]
        DB::table('san_pham')
            ->where('id', $id)
            ->update(['status' => 0]);

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa tạm thời!');
    }

}