@extends('components.laptop-layout')

@section('title', 'Trang chủ - Laptop Store')

@section('content')
<div class="container mt-4">

    <!-- Phần Danh sách Laptop -->
    <h2 class="text-center mb-4" style="color: #122333; font-weight: bold;">
        DANH SÁCH LAPTOP MỚI NHẤT
    </h2>
   
    <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
        <span class="fw-bold text-secondary">Tìm kiếm theo:</span>
       
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}"
           class="btn {{ request('sort') == 'asc' ? 'btn-primary' : 'btn-outline-secondary' }} shadow-sm">
            Giá tăng dần
        </a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}"
           class="btn {{ request('sort') == 'desc' ? 'btn-primary' : 'btn-outline-secondary' }} shadow-sm">
            Giá giảm dần
        </a>
    </div>

    <div class="row">
        @forelse($laptops as $item)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card shadow-sm h-100 p-3 text-center">
                    
                    <a href="{{ url('laptop/chitiet/' . $item->id) }}">
                        <img src="{{ asset('storage/image/' . $item->hinh_anh) }}" 
                             alt="{{ $item->tieu_de }}" 
                             class="img-fluid d-block mx-auto mb-2"
                             style="max-height: 180px; object-fit: contain;">
                    </a>

                    <div class="card-body p-0 mt-2">
                        <a href="{{ url('laptop/chitiet/' . $item->id) }}" class="text-decoration-none text-dark">
                            <h6 class="fw-bold text-truncate" title="{{ $item->tieu_de }}">{{ $item->tieu_de }}</h6>
                        </a>
                       
                        <p class="text-danger fw-bold mb-2">
                            {{ number_format($item->gia, 0, ",", ".") }} đ
                        </p>
                       
                        <p class="text-muted small fst-italic mb-3">
                            Nhu cầu: {{ $item->nhu_cau ?? 'Không xác định' }}
                        </p>

                        <!-- Nút Thêm vào giỏ hàng trực tiếp -->
                        <form action="{{ route('cart.add', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm w-100">
                                <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                Không tìm thấy sản phẩm nào phù hợp.
            </div>
        @endforelse
    </div>

    <hr class="my-5" style="border-top: 2px dashed #ccc;">
<!-- Phần Giỏ hàng -->
    <h2 id="phan-gio-hang" class="text-center mb-4 pt-4" style="color: #122333; font-weight: bold;">
        GIỎ HÀNG CỦA BẠN
    </h2>
        GIỎ HÀNG CỦA BẠN
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
        <div class="text-center py-5 mb-5 bg-light rounded shadow-sm">
            <h4 class="text-muted">Giỏ hàng của bạn đang trống</h4>
            <p>Hãy chọn thêm sản phẩm ở phía trên nhé!</p>
        </div>
    @else
        <div class="table-responsive shadow-sm mb-4">
            <table class="table table-bordered table-hover text-center align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                        <th>Thao tác</th>
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
                            <td class="text-start fw-bold">{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td class="text-end">{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                            <td class="text-end text-danger fw-bold">{{ number_format($subtotal, 0, ',', '.') }} đ</td>
                            <td>
                                <form action="{{ route('cart.delete', $id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                        Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-warning">
                        <td colspan="4" class="text-end fw-bold fs-5">Tổng thanh toán:</td>
<td class="text-end text-danger fw-bold fs-5">{{ number_format($total, 0, ',', '.') }} đ</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Hình thức thanh toán + Đặt hàng -->
        <div class="row mt-4 mb-5">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-3">Hình thức thanh toán</h5>
                       
                        <select class="form-select mb-4">
                            <option selected>Tiền mặt khi nhận hàng (COD)</option>
                            <option>Chuyển khoản ngân hàng</option>
                            <option>Thanh toán qua VNPay / Momo</option>
                        </select>

                        <form action="{{ route('cart.checkout') }}" method="POST"
                              onsubmit="return confirm('Xác nhận đặt hàng? Giỏ hàng sẽ được xóa sau khi đặt hàng thành công.');">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 py-3 fw-bold fs-5">
                                ĐẶT HÀNG NGAY
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
