@extends('Admin.layouts.app')
@section('title', 'Sửa Gói VIP')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Sửa Gói VIP</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.vip.index') }}">Quản Lý Gói VIP</a></li>
                    <li class="breadcrumb-item active">Sửa Gói VIP</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <form class="card card-default" method="POST" action="{{ route('admin.vip.update', $vip->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header">
                <h3 class="card-title">Thông Tin Gói VIP</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="package_type">Tên Gói VIP</label>
                            <input type="text" class="form-control" id="package_type" name="package_type" placeholder="Tên gói VIP" value="{{ $vip->package_type }}">
                        </div>
                        <div class="form-group">
                            <label for="price">Giá</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Giá" value="{{ $vip->price }}">
                        </div>
                        <div class="form-group">
                            <label for="duration_days">Thời Gian (ngày)</label>
                            <input type="number" class="form-control" id="duration_days" name="duration_days" placeholder="Thời gian (ngày)" value="{{ $vip->duration_days }}">
                        </div>
                        <div class="form-group">
                            <label for="duration_days">Bài Đăng (tối đa)</label>
                            <input type="number" class="form-control" id="post_number" name="post_number" placeholder="Bài đăng (tối đa)" value="{{ $vip->post_number }}">
                        </div>
                        <div class="form-group">
                            <label for="benefits">Lợi Ích</label>
                            <textarea class="form-control" id="benefits" name="benefits" placeholder="Lợi ích">{{ $vip->benefits }}</textarea>
                        </div>
                    </div>
                </div>
                <a class="btn btn-success" href="{{ route('admin.vip.index') }}">Quay Lại</a>
                <button type="submit" class="btn btn-primary">Lưu Thông Tin</button>
            </div>
        </form>
    </div><!-- /.container-fluid -->
</section>
@endsection
