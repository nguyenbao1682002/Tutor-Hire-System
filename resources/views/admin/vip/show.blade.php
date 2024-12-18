@extends('Admin.layouts.app')
@section('title', 'Quản Lý Gói VIP')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Quản Lý Gói VIP</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Quản Lý Gói VIP</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            @forelse($vipPackages as $vipPackage)
                <div class="col-md-4">
                    <div class="card shadow-md">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold text-center">{{ $vipPackage->package_type }}</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <strong>Giá Thuê:</strong> <span
                                    class="text-primary">{{ number_format($vipPackage->price, 0, ',', '.') }} VND</span><br>
                                <strong>Thời Hạn:</strong> {{ $vipPackage->duration_days }} ngày<br>
                                <strong>Bài Viết (tối đa):</strong> {{ $vipPackage->post_number }} bài
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                @if($vipPackage->is_active)
                                    <span class="btn btn-success btn-sm">Đang Sử Dụng</span>
                                @else
                                    <a onclick="return confirmRegistration()" href="{{ route('admin.vip.register', $vipPackage->id) }}"
                                        class="btn btn-primary btn-sm"><i class="fa-solid fa-user-plus"></i> Đăng Ký Gói</a>
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
    </div><!-- /.container-fluid -->
</section>
@endsection
@section('script')
<script>
    function confirmRegistration() {
        // Hiển thị hộp thoại xác nhận
        return confirm("Bạn có chắc chắn muốn đăng ký gói VIP này không?");
    }
</script>
@endsection