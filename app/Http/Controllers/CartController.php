<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
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
    public function remove($id)
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
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                             ->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // TODO: Sau này sẽ lưu vào bảng orders và order_items
        // Hiện tại chỉ giả lập đặt hàng thành công

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Xóa giỏ hàng sau khi đặt hàng
        session()->forget('cart');

        return redirect()->route('cart.index')
                         ->with('success', '🎉 Đặt hàng thành công! 
                         Tổng tiền: ' . number_format($total, 0, ',', '.') . ' đ. 
                         Cảm ơn bạn đã mua hàng!');
    }
}