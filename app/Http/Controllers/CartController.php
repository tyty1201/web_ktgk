<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    // 1. SỬA LẠI HÀM NÀY
    public function index()
    {
        // Vì giỏ hàng đã nằm ở trang chủ, ta chuyển hướng về trang chủ
        // Thêm '#phan-gio-hang' để trình duyệt tự động cuộn xuống phần giỏ hàng
        return redirect('/#phan-gio-hang');
    }

    
    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->ten ?? $product->tieu_de ?? 'Sản phẩm không tên',
                'price'    => $product->gia,
                'image'    => $product->hinh_anh,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    // Xóa một sản phẩm khỏi giỏ hàng
    public function delete($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    // Xóa toàn bộ giỏ hàng
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }

    // ==================== XỬ LÝ ĐẶT HÀNG ====================
    // 2. SỬA LẠI ĐƯỜNG DẪN TRONG HÀM CHECKOUT (Ở DƯỚI CÙNG)
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            // Sửa route('cart.index') thành redirect
            return redirect('/#phan-gio-hang')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Xóa giỏ hàng sau khi đặt hàng
        session()->forget('cart');

        // Sửa route('cart.index') thành redirect
        return redirect('/#phan-gio-hang')
                ->with('success', '🎉 Đặt hàng thành công! Tổng tiền: ' . number_format($total, 0, ',', '.') . ' đ. Cảm ơn bạn đã mua hàng!');
    }
}