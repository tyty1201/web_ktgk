@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <h3 class="text-center text-primary fw-bold mb-4">QUẢN LÝ SẢN PHẨM</h3>
    
    <div class="card shadow-sm p-3">
        <table id="productTable" class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Tiêu đề</th>
                    <th>CPU</th>
                    <th>RAM</th>
                    <th>Ổ cứng</th>
                    <th>Khối lượng</th>
                    <th>Nhu cầu</th>
                    <th>Giá</th>
                    <th>Ảnh</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr>
                    <td style="font-size: 13px; max-width: 250px;">{{ $p->tieu_de }}</td>
                    <td class="small">{{ $p->cpu }}</td>
                    <td class="small">{{ $p->ram }}</td>
                    <td class="small">{{ $p->luu_tru }}</td>
                    <td class="text-center small">{{ $p->khoi_luong }}</td>
                    <td class="text-center small">{{ $p->nhu_cau }}</td>
                    <td class="text-center fw-bold">{{ number_format($p->gia, 0, ',', '.') }} VNĐ</td>
                    <td class="text-center">
                        <img src="{{ asset('storage/image/' . $p->hinh_anh) }}" width="50" class="border">
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="/laptop/{{ $p->id }}" class="btn btn-primary btn-sm">Xem</a>
                            
                            <form action="{{ route('admin.products.delete', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa sản phẩm này?')">Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#productTable').DataTable({
            "pageLength": 10, // Hiển thị đúng 10 sản phẩm mỗi trang theo yêu cầu [cite: 45]
            "language": {
                "search": "Search:",
                "lengthMenu": "_MENU_ entries per page",
                "paginate": {
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });
    });
</script>
@endsection