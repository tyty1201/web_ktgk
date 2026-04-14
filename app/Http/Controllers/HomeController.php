<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(){
            $laptops = DB::table('san_pham')           
                ->limit(20)
                ->get();
        
                return view('laptop.index', compact('laptops'));
    }   

    public function category(Request $request, $id)
    {
        $sort = $request->query('sort', 'asc'); 
    
        // Truy vấn: Lọc theo id_danh_muc, status=1 và sắp xếp theo giá
        $laptops = DB::table('san_pham')
            ->where('id_danh_muc', $id)
            ->orderBy('gia', $sort) 
            ->get();
    
        // Lấy tên thương hiệu để hiển thị (nếu cần)
        $brand = DB::table('danh_muc_laptop')->where('id', $id)->first();
    
        return view('laptop.index', compact('laptops', 'id', 'sort'));
    }
    
        public function show($id)
        {
            $laptop = DB::table('san_pham')->where('id', $id)->first();
    
            if (!$laptop) {
                abort(404);
            }
    
            return view('laptop.show', compact('laptop'));       
         }

         public function search(Request $request)
         {
             $keyword = $request->input('keyword');
         
             // Dùng đúng câu lệnh gợi ý từ đề bài
             $laptops = DB::select("select * from san_pham where tieu_de like ?", ["%".$keyword."%"]);
         
             return view('laptop.index', compact('laptops'));
         }

         public function addToCart(Request $request, $id)
         {
             // Lấy giỏ hàng hiện tại từ session, nếu chưa có thì tạo mảng rỗng
             $cart = session()->get('cart', []);
         
             // Tìm thông tin sản phẩm
             $laptop = DB::table('san_pham')->where('id', $id)->first();
         
             if(!$laptop) {
                 return redirect()->back()->with('error', 'Sản phẩm không tồn tại!');
             }
         
             $quantity = $request->input('quantity', 1);
         
             // Nếu sản phẩm đã có trong giỏ, tăng số lượng
             if(isset($cart[$id])) {
                 $cart[$id]['quantity'] += $quantity;
             } else {
                 // Nếu chưa có, thêm mới vào mảng
                 $cart[$id] = [
                     "name" => $laptop->tieu_de,
                     "quantity" => $quantity,
                     "price" => $laptop->gia,
                     "image" => $laptop->hinh_anh
                 ];
             }
         
             // Lưu lại vào session
             session()->put('cart', $cart);
         
             return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
         }

}


