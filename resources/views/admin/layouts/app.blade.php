<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ asset('dist/img/AdminLTELogo.png') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet"
        href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            @php
                $giaSu = \App\Models\GiaSu::where('user_id', auth()->user()->id)->first();
            @endphp
            @if (auth()->user()->role == "gia_su")
                <ul class="navbar-nav ml-auto">
                    <!-- Messages Dropdown Menu -->
                    <li class="nav-item">
                        <h3 class="card-title"><a href="{{ route('admin.profile.edit') }}"><i class="fa-regular fa-user"></i> {{ auth()->user()->name }}</a> <a href="{{ route('admin.deposit.index') }}">({{ number_format($giaSu->balance) }} VNĐ)</a></h3>
                    </li>
                </ul>
            @endif

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Hệ Thống Quản Lý</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview menu-open">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Trang Chủ
                                </p>
                            </a>
                        </li>

                        @if (auth()->user()->role == "admin")
                            <li class="nav-header">QUẢN LÝ GIA SƯ</li>
                        @else
                            <li class="nav-header">QUẢN LÝ NỘI DUNG</li>
                        @endif
                        @if (auth()->user()->role == "admin")
                            <li class="nav-item has-treeview">
                                <a href="{{ route('admin.tutor.index') }}" class="nav-link">
                                    <i class="nav-icon fa-solid fa-graduation-cap"></i>
                                    <p>
                                        Gia Sư
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item has-treeview">
                            <a href="{{ route('admin.post.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-signs-post"></i>
                                <p>
                                    Bài Viết
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="{{ route('admin.subject.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-book-open"></i>
                                <p>
                                    Môn Học
                                </p>
                            </a>
                        </li>

                        @if (auth()->user()->role == "admin")
                            <li class="nav-header">QUẢN LÝ PHỤ HUYNH</li>
                        @else
                            <li class="nav-header">QUẢN LÝ PHẢN HỒI</li>
                        @endif

                        @if (auth()->user()->role == "admin")
                            <li class="nav-item has-treeview">
                                <a href="{{ route('admin.phuhuynh.index') }}" class="nav-link">
                                    <i class="nav-icon fa-solid fa-user-group"></i>
                                    <p>
                                        Phụ Huynh
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item has-treeview">
                            <a href="{{ route('admin.review.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-star-half-stroke"></i>
                                <p>
                                    Đánh Giá
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="{{ route('admin.comment.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-comments"></i>
                                <p>
                                    Bình Luận
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">QUẢN LÝ GÓI VIP</li>
                        @if (auth()->user()->role == "gia_su")
                            <li class="nav-item has-treeview">
                                <a href="{{ route('admin.deposit.index') }}" class="nav-link">
                                    <i class="nav-icon fa-solid fa-money-bill-wave"></i>
                                    <p>
                                        Nạp Tiền
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item has-treeview">
                            <a href="{{ route('admin.vip.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-crown"></i>
                                <p>
                                    Gói Vip
                                </p>
                            </a>
                        </li>

                        @if (auth()->user()->role == "admin")
                            <li class="nav-item has-treeview">
                                <a href="{{ route('admin.transaction.index') }}" class="nav-link">
                                    <i class="nav-icon fa-solid fa-money-bill-wave"></i>
                                    <p>
                                        Giao Dịch
                                    </p>
                                </a>
                            </li>
                        @endif

                        <li class="nav-header">CÀI ĐẶT CHUNG</li>
                        @if (auth()->user()->role == "admin")
                            <li class="nav-item has-treeview">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fa-solid fa-gear"></i>
                                    <p>
                                        Cấu Hình
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item has-treeview">
                            <a href="{{ route('admin.profile.edit') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-lock"></i>
                                <p>
                                    Đổi Thông Tin
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="{{ route('admin.logout') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                                <p>
                                    Đăng Xuất
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper" style="min-height: 1203.31px;">
            @yield('content')
        </div>

        <footer class="main-footer">
            <strong>&copy; 2023-2024 - Trang dành cho <a href="#">Quản trị viên</a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Phiên bản</b> 1.0.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    @yield('css')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@yield('script')
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            $(document).ready(function () {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 5000
                };
                toastr.error('{{ $error }}', 'Thất Bại!');
            });
        </script>
    @endforeach
@endif

@if (session('success'))
    <script>
        $(document).ready(function () {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 5000
            };
            toastr.success('{{ session('success') }}', 'Thành Công!');
        });
    </script>
@endif

@if (session('error'))
    <script>
        $(document).ready(function () {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 5000
            };
            toastr.error('{{ session('error') }}', 'Thất Bại!');
        });
    </script>
@endif