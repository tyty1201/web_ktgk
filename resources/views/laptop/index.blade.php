<x-laptop-layout title="Danh sách laptop mới nhất">
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6 text-center">DANH SÁCH LAPTOP MỚI NHẤT</h2>
        
        <div class="flex justify-center items-center space-x-4 mb-8">
            <span class="font-semibold text-gray-700">Tìm kiếm theo:</span>
            
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}" 
               class="border px-4 py-1 rounded shadow-sm transition {{ request('sort') == 'asc' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                Giá tăng dần
            </a>

            <a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}" 
               class="border px-4 py-1 rounded shadow-sm transition {{ request('sort') == 'desc' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                Giá giảm dần
            </a>
        </div>
        <div class="list-movie flex flex-wrap -mx-2">
            @foreach($laptops as $item)
                <div class="movie w-1/4 p-2">
                    <div class="border rounded-lg overflow-hidden shadow-lg bg-white p-4 text-center">
                        
                        <a href="{{ url('laptop/chitiet/' . $item->id) }}">
                            <img src="{{ asset('storage/image/' . $item->hinh_anh) }}" 
                                 alt="{{ $item->ten }}" 
                                 width="200px" height="200px" 
                                 class="mx-auto object-cover mb-2">
                        </a>
                        <br>

                        <a href="{{ url('laptop/chitiet/' . $item->id) }}" class="hover:text-blue-600">
                            <b>{{ $item->tieu_de }}</b>
                        </a>
                        <br>
                        
                        <i class="text-red-600">
                            {{ number_format($item->gia, 0, ",", ".") }}đ
                        </i>
                        
                        <div class="text-gray-500 text-sm mt-2 italic">
                            Nhu cầu: {{ $item->nhu_cau }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($laptops->isEmpty())
            <div class="text-center py-10 text-gray-500">
                Không tìm thấy sản phẩm nào phù hợp.
            </div>
        @endif
    </div>
</x-laptop-layout>