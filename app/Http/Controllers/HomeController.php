<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        return view("laptop.index");
    }

    /**
     * Xử lý tìm kiếm laptop
     */
    public function search(Request $request)
    {
        $keyword = trim($request->get('keyword'));

        // Nếu không nhập từ khóa thì quay lại trang chủ
        if (empty($keyword)) {
            return redirect()->back()->with('error', 'Vui lòng nhập từ khóa tìm kiếm!');
        }

        // Tìm kiếm trên nhiều trường
        $products = Product::where(function ($query) use ($keyword) {
            $query->where('ten', 'LIKE', "%{$keyword}%")
                  ->orWhere('tieu_de', 'LIKE', "%{$keyword}%")
                  ->orWhere('cpu', 'LIKE', "%{$keyword}%")
                  ->orWhere('series_model', 'LIKE', "%{$keyword}%")
                  ->orWhere('nhu_cau', 'LIKE', "%{$keyword}%")
                  ->orWhere('mau_sac', 'LIKE', "%{$keyword}%")
                  ->orWhere('chip_do_hoa', 'LIKE', "%{$keyword}%");
        })
        ->orderBy('gia', 'desc')        // Sắp xếp theo giá cao đến thấp
        ->get();

        $title = 'Kết quả tìm kiếm cho: "' . $keyword . '"';

        return view('search', compact('products', 'keyword', 'title'));
    }
}