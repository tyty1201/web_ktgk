@extends('layouts.laptop-layout')

@section('title', $title ?? 'Tìm kiếm laptop')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">
        Kết quả tìm kiếm cho: <strong>"{{ $keyword ?? '' }}"</strong>
    </h2>

    @if (isset($products) && $products->isEmpty())
        <div class="text-center py-5">
            <h4>Không tìm thấy sản phẩm nào phù hợp với từ khóa "{{ $keyword ?? '' }}"</h4>
            <a href="/" class="btn btn-primary mt-3">Quay về trang chủ</a>
        </div>
    @elseif (isset($products))
        <div class="list-laptop row">
            @foreach ($products as $product)
                <div class="laptop col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset($product->hinh_anh ?? '') }}" 
                             class="card-img-top" 
                             alt="{{ $product->ten ?? 'Laptop' }}" 
                             style="height: 200px; object-fit: contain; padding: 10px;">
                        
                        <div class="laptop-info card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->ten ?? $product->tieu_de }}</h5>
                            <p class="text-danger fw-bold fs-5 mb-2">
                                {{ number_format($product->gia ?? 0, 0, ',', '.') }} VND
                            </p>
                            
                            <a href="#" class="btn btn-success mt-auto">
                                Thêm vào giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection