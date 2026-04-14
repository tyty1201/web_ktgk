@extends('components.laptop-layout')

@section('title', $laptop->tieu_de)

@section('content')
<div class="container py-5 px-4 bg-white shadow-sm rounded mt-4 mb-5">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <strong>Thành công!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-5">
        <div class="col-md-5 mb-4 mb-md-0">
            <div class="border rounded p-3 text-center h-100 d-flex align-items-center justify-content-center">
                <img src="{{ asset('storage/image/' . $laptop->hinh_anh) }}" 
                     alt="{{ $laptop->tieu_de }}" 
                     class="img-fluid" style="max-height: 350px; object-fit: contain;">
            </div>
        </div>

        <div class="col-md-7">
            <h3 class="fw-bold text-dark mb-4">{{ $laptop->tieu_de }}</h3>
            
            <div class="text-secondary mb-4" style="line-height: 1.8;">
                <p class="mb-1"><b class="text-dark">CPU:</b> {{ $laptop->cpu }}</p>
                <p class="mb-1"><b class="text-dark">RAM:</b> {{ $laptop->ram }}</p>
                <p class="mb-1"><b class="text-dark">Chip đồ họa:</b> {{ $laptop->chip_do_hoa }}</p>
                <p class="mb-1"><b class="text-dark">Nhu cầu:</b> {{ $laptop->nhu_cau }}</p>
                <p class="mb-1"><b class="text-dark">Màn hình:</b> {{ $laptop->man_hinh }}</p>
                <p class="mb-1"><b class="text-dark">Hệ điều hành:</b> {{ $laptop->he_dieu_hanh }}</p>
                
                <p class="fs-4 mt-3 mb-0">
                    <b class="text-dark">Giá: </b>
                    <span class="text-danger fw-bold">{{ number_format($laptop->gia, 0, ',', '.') }} VNĐ</span>
                </p>
            </div>

            <form action="{{ route('cart.add', $laptop->id) }}" method="POST" class="d-flex align-items-center gap-3 border-top pt-4 mt-2">
                @csrf
                <div class="d-flex align-items-center">
                    <span class="me-2 fw-bold text-dark">Số lượng:</span>
                    <input type="number" name="quantity" value="1" min="1" 
                           class="form-control text-center fw-bold" style="width: 80px;">
                </div>
                
                <button type="submit" class="btn btn-primary fw-bold px-4 py-2">
                    <i class="fa fa-cart-plus me-1"></i> Thêm vào giỏ hàng
                </button>
            </form>
        </div>
    </div>

    <div class="border-top pt-4">
        <h5 class="fw-bold text-dark mb-3 text-uppercase border-bottom pb-2" style="display: inline-block;">Thông tin chi tiết khác</h5>
        <div class="row text-secondary mt-2">
            <div class="col-md-6">
                <p class="mb-2"><b class="text-dark">Khối lượng:</b> {{ $laptop->khoi_luong }}</p>
                <p class="mb-2"><b class="text-dark">Webcam:</b> {{ $laptop->webcam }}</p>
                <p class="mb-2"><b class="text-dark">Pin:</b> {{ $laptop->pin }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-2"><b class="text-dark">Kết nối không dây:</b> {{ $laptop->ket_noi_khong_day }}</p>
                <p class="mb-2"><b class="text-dark">Bàn phím:</b> {{ $laptop->ban_phim }}</p>
                <p class="mb-2"><b class="text-dark">Cổng kết nối:</b> {{ $laptop->cong_ket_noi }}</p>
            </div>
        </div>
    </div>

</div>
@endsection