<x-laptop-layout :title="$laptop->tieu_de">
    <div class="container mx-auto py-8 px-4 bg-white shadow-lg rounded-lg mt-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap -mx-4">
            <div class="w-full md:w-5/12 px-4 mb-6">
                <div class="border rounded-lg p-2">
                    <img src="{{ asset('storage/images/' . $laptop->hinh_anh) }}" 
                         alt="{{ $laptop->tieu_de }}" 
                         class="w-full h-auto object-contain mx-auto">
                </div>
            </div>

            <div class="w-full md:w-7/12 px-4">
                <h1 class="text-xl font-bold text-gray-800 mb-4">{{ $laptop->tieu_de }}</h1>
                
                <div class="space-y-1 text-sm text-gray-700 mb-6">
                    <p><b>CPU:</b> {{ $laptop->cpu }}</p>
                    <p><b>RAM:</b> {{ $laptop->ram }}</p>
                    <p><b>Chip đồ họa:</b> {{ $laptop->chip_do_hoa }}</p>
                    <p><b>Nhu cầu:</b> {{ $laptop->nhu_cau }}</p>
                    <p><b>Màn hình:</b> {{ $laptop->man_hinh }}</p>
                    <p><b>Hệ điều hành:</b> {{ $laptop->he_dieu_hanh }}</p>
                    <p class="text-lg mt-2">
                        <b class="text-gray-800">Giá: </b>
                        <span class="text-red-600 font-bold">{{ number_format($laptop->gia, 0, ',', '.') }} VNĐ</span>
                    </p>
                </div>

                <form action="{{ route('cart.add', $laptop->id) }}" method="POST" class="flex items-center space-x-4 border-t pt-6">
                    @csrf
                    <div class="flex items-center">
                        <span class="mr-2 font-semibold">Số lượng mua:</span>
                        <input type="number" name="quantity" value="1" min="1" 
                               class="w-16 border rounded px-2 py-1 text-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition">
                        Thêm vào giỏ hàng
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-10 border-t pt-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4 underline">Thông tin khác</h2>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-2 text-sm text-gray-700">
                <p><b>Khối lượng:</b> {{ $laptop->khoi_luong }}</p>
                <p><b>Webcam:</b> {{ $laptop->webcam }}</p>
                <p><b>Pin:</b> {{ $laptop->pin }}</p>
                <p><b>Kết nối không dây:</b> {{ $laptop->ket_noi_khong_day }}</p>
                <p><b>Bàn phím:</b> {{ $laptop->ban_phim }}</p>
                <p><b>Cổng kết nối:</b> {{ $laptop->cong_ket_noi }}</p>
            </div>
        </div>
    </div>
</x-laptop-layout>