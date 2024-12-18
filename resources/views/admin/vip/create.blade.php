@extends('Admin.layouts.app')
@section('title', 'Thêm Gói VIP')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Thêm Gói VIP</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.vip.index') }}">Quản Lý Gói VIP</a></li>
                    <li class="breadcrumb-item active">Thêm Gói VIP</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <form class="card card-default" method="POST" action="{{ route('admin.vip.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Thông Tin Gói VIP</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="package_type">Loại Gói</label>
                            <input type="text" class="form-control" id="package_type" name="package_type" placeholder="Tên loại gói VIP">
                        </div>
                        <div class="form-group">
                            <label for="price">Giá (VND)</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Nhập giá gói VIP">
                        </div>
                        <div class="form-group">
                            <label for="duration_days">Thời Hạn (ngày)</label>
                            <input type="number" class="form-control" id="duration_days" name="duration_days" placeholder="Nhập thời hạn (ngày)">
                        </div>
                        <div class="form-group">
                            <label for="duration_days">Số Bài Đăng</label>
                            <input type="number" class="form-control" id="post_number" name="post_number" placeholder="Nhập bài đăng (tối đa)">
                        </div>
                        <div class="form-group">
                            <label for="benefits">Lợi Ích</label>
                            <textarea class="form-control" id="benefits" name="benefits" rows="3" placeholder="Mô tả lợi ích của gói VIP"></textarea>
                        </div>
                    </div>
                </div>
                <a class="btn btn-success" href="{{ route('admin.vip.index') }}">Quay Lại</a>
                <button type="submit" class="btn btn-primary">Lưu Thông Tin</button>
            </div>
        </form>
    </div><!-- /.container-fluid -->
</section>
<style>
    .form-control:disabled, .form-control[readonly] {
        background-color: white;
        opacity: 1;
    }
</style>
@endsection
