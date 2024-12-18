@extends('Web.layouts.app')
@section('title', 'Gói Vip')
@section('content')
<div class="main_content shop pb-80">
    <div class="archive-header shop-header header-bg2 pt-50 pb-50 mb-80" style="background-image: url({{ asset('assets/imgs/theme/shop-header-bg-2.jpg') }});">
        <div class="container">
            <div class="row align-items-center h-100">
                <div class="col-md-6 mx-auto">
                    <h2><span class="color6">Gói Vip</span></h2>
                </div>
                <div class="col-md-6 mx-auto text-center text-md-right">
                    <div class="breadcrumb">
                        <a href="{{ route('web.home.index') }}"><i class="ti-home mr-5"></i>Trang Chủ</a><span></span>
                        Gói Vip
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @forelse($vipPackages as $vipPackage)
                <div class="col-md-4">
                    <div class="card shadow-md">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold text-center text-danger">{{ $vipPackage->package_type }}</h3>
                        </div>
                        <div class="card-body">
                            <strong>Giá Thuê:</strong> 
                            <p class="text-danger"><b>{{ number_format($vipPackage->price, 0, ',', '.') }} VND</b></p>
                            <strong>Thời Hạn: <p>{{ $vipPackage->duration_days }} ngày</p></strong> 
                            <strong>Mô tả gói:</strong> <p>{{ $vipPackage->benefits }}</p>

                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                @if($vipPackage->is_active)
                                    <span class="btn btn-fill-out btn-dark">Đang Sử Dụng</span>
                                @else
                                    <a onclick="return confirmRegistration()" href="{{ route('web.vip.register', $vipPackage->id) }}"
                                        class="btn btn-fill-out btn-danger"> Đăng Ký Gói</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert text-center">Không tìm thấy gói VIP nào</div>
                </div>
            @endforelse
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    function confirmRegistration() {
        // Hiển thị hộp thoại xác nhận
        return confirm("Bạn có chắc chắn muốn đăng ký gói VIP này không?");
    }
</script>
@if (session('success'))
    <script>
        $(document).ready(function () {
            Toastify({
                text: '{{ session('success') }}',
                duration: 5000, // thời gian hiển thị (ms)
                close: true, // nút đóng
                gravity: "top", // vị trí: "top" hoặc "bottom"
                position: "center", // "left", "center", "right"
            }).showToast();
        });
    </script>
@endif
@if (session('error'))
    <script>
        $(document).ready(function () {
            Toastify({
                text: '{{ session('error') }}',
                duration: 5000, // thời gian hiển thị (ms)
                close: true, // nút đóng
                gravity: "top", // vị trí: "top" hoặc "bottom"
                position: "center", // "left", "center", "right"
            }).showToast();
        });
    </script>
@endif
@endsection