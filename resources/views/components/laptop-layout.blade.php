@props(['title' => 'Danh sách Laptop mới nhất'])

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>{{ $title ?? 'Laptop Store' }}</title>
    
    <link rel="stylesheet" href="{{asset('library/bootstrap.min.css')}}">
    <script src="{{asset('library/jquery.slim.min.js')}}"></script>
    <script src="{{asset('library/popper.min.js')}}"></script>
    <script src="{{asset('library/bootstrap.bundle.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{asset('library/jquery-3.7.1.js')}}" ></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap4.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap4.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 14px;
        
        }

        .container {
            max-width: 1000px; /* Chiều rộng tối đa của nội dung */
            margin: 0 auto; /* Căn giữa nội dung */
            padding: 0 15px;
        }

        .navbar {
            background-color: #122333;
            padding: 8px 0;
            max-width: 1200px;
            margin: 0 auto;
        }

        .nav-link {
            color: #fff !important;
            font-weight: bold;
        }

        .nav-link:hover {
            color: #ffc107 !important;
        }

        .search-bar {
            max-width: 420px;
            position: relative;
        }

        .search-bar input {
            width: 100%;
            padding: 8px 15px;
            border: none;
            border-radius: 30px;
            background-color: white;
        }

        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: #122333;
            color: white;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
        }

        .cart-icon {
            font-size: 1.6rem;
            color: #fff;
            position: relative;
            padding: 0 10px;
        }

        .cart-icon:hover {
            color: #ffc107;
        }

        .cart-count {
            position: absolute;
            top: -6px;
            right: -6px;
            background-color: #dc3545;
            color: white;
            font-size: 0.75rem;
            font-weight: bold;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-dropdown button {
            background-color: #28a745;
            border: none;
        }

        .list-laptop
        {
            display:grid;
            grid-template-columns:repeat(5,20%);
        }
        .laptop
        {
            margin:10px;
            text-align:center;
            border-radius:5px;
            border:1px solid #dbdbdb;
            overflow: hidden;
            cursor:pointer;
        }
        .laptop a
        {
            color: black;
            text-decoration:none;
        }
        .laptop-info
        {
            display:grid;
            grid-template-columns:repeat(2,30% 70%);
        }

        .list-laptop
        {
            display:grid;
            grid-template-columns:repeat(5,20%);
        }
        .laptop
        {
            margin:10px;
            text-align:center;
            border-radius:5px;
            border:1px solid #dbdbdb;
            overflow: hidden;
            cursor:pointer;
        }
        .laptop a
        {
            color: black;
            text-decoration:none;
        }
        .laptop-info
        {
            display:grid;
            grid-template-columns:repeat(2,30% 70%);
        }
    </style>
</head>
<body>
    <header>
        <div style="text-align:center; max-width:1200px; margin:0 auto">
            <img src="{{asset('images/banner.png')}}" width="1200px" alt="Banner">

            <nav class="navbar navbar-expand-sm">
                <div class="container-fluid">
                    
                    <!-- 1. Các hãng laptop -->
                    <div class="col-5">
                        <ul class="navbar-nav">
                            @if(isset($categories) && $categories->count() > 0)
                                @foreach($categories as $category)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{url('laptop/theloai/'.$category->id)}}">
                                            {{$category->ten_danh_muc}}
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <!-- Hiển thị mặc định khi chưa có categories -->
                                <li class="nav-item"><a class="nav-link" href="#">Dell</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Lenovo</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">HP</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Asus</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Acer</a></li>
                            @endif
                        </ul>
                    </div>

                    <!-- 2. Khung tìm kiếm -->
                    <div class="col-4 search-bar">
                        <form method="post" action="{{url('/timkiem')}}">
                            {{ csrf_field() }}
                            <input type="text" name="keyword" placeholder="Tìm kiếm laptop...">
                            <button type="submit" class="search-btn">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <div style='color:white;position:relative' class='mr-2'>
                        <div style='width:20px; height:20px;background-color:#23b85c; font-size:12px; border:none;
                             border-radius:50%; position:absolute;right:2px;top:-2px' id='cart-number-product'>
                                @if (session('cart'))
                                     {{ count(session('cart')) }}
                                @else
                                    0
                                @endif
                        </div>
                        <a href="{{url('/gio-hang')}}" style='cursor:pointer;color:white;'>
                            <i class="fa fa-cart-arrow-down fa-2x mr-2 mt-1" aria-hidden="true"></i>
                        </a>
                    </div>

                    <div class='col-2 p-0 d-flex'>
                        @auth
                            <div class="dropdown user-dropdown">
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </button>
                                <div class="dropdown-menu">
                                <a class="dropdown-item" href="">Quản lý</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" onclick="event.preventDefault();
                                                        this.closest('form').submit();">Đăng xuất</a>
                                </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Đăng nhập</a>
                            <a href="{{ route('register') }}" class="btn btn-sm btn-success">Đăng ký</a>
                        @endauth

                    </div>

                </div>
            </nav>
        </div>
    </header>
    <main class='container'>
        {{$slot}}
    </main>
</body>
</html>