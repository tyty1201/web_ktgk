@extends('layouts.laptop-layout')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4" style="color: #122333; font-weight: bold;">
        DANH SÁCH SẢN PHẨM
    </h2>

    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    @if (empty(session('cart')))
        <div class="text-center py-5">
            <h4>Giỏ hàng của bạn đang trống</h4>
            <a href="/" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $stt = 1; 
                        $total = 0; 
                    @endphp
                    @foreach (session('cart') as $id => $item)
                        @php 
                            $subtotal = $item['price'] * $item['quantity']; 
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $stt++ }}</td>
                            <td class="text-start">{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td class="text-end">{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                            <td class="text-end">{{ number_format($subtotal, 0, ',', '.') }} đ</td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-warning">
                        <td colspan="4" class="text-end fw-bold">Tổng cộng</td>
                        <td class="text-end fw-bold">{{ number_format($total, 0, ',', '.') }} đ</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Hình thức thanh toán + Đặt hàng -->
        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-3">Hình thức thanh toán</h5>
                        
                        <select class="form-select mb-4">
                            <option selected>Tiền mặt khi nhận hàng</option>
                            <option>Chuyển khoản ngân hàng</option>
                            <option>Thanh toán qua VNPay / Momo</option>
                        </select>

                        <!-- Form Đặt hàng -->
                        <form action="{{ route('cart.checkout') }}" method="POST" 
                              onsubmit="return confirm('Xác nhận đặt hàng? Giỏ hàng sẽ được xóa sau khi đặt hàng thành công.');">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 py-3 fw-bold fs-5">
                                ĐẶT HÀNG
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection