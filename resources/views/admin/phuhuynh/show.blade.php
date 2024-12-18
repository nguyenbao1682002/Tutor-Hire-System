@extends('Admin.layouts.app')
@section('title', 'Quản Lý Phụ Huynh')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Quản Lý Phụ Huynh</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.post.index') }}">Quản Lý Phụ Huynh</a></li>
                    <li class="breadcrumb-item active">Cập Nhật</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Thông Tin Phụ Huynh</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Họ Tên</label>
                            <input type="text" class="form-control" value="{{ $phuhuynh->user->name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="slug">Email</label>
                            <input type="text" class="form-control" value="{{ $phuhuynh->user->email }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="fee">Số Điện Thoại</label>
                            <input type="text" class="form-control" value="{{ $phuhuynh->phone_number }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="fee">Địa Chỉ</label>
                            <input type="text" class="form-control" value="{{ $phuhuynh->address }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="name">Số Dư Hiện Tại</label>
                            <input type="text" class="form-control" value="{{ number_format($phuhuynh->balance) }}đ" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <form class="col-6" method="POST", action="{{ route('admin.phuhuynh.balance', $phuhuynh->id) }}">
                @csrf
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Thông Tin Số Dư</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="slug">Hành Động</label>
                                    <select name="action" class="form-control">
                                        <option value="add">Cộng Tiền</option>
                                        <option value="sub">Trừ Tiền</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="blance">Số Tiền</label>
                                    <input type="number" class="form-control" id="blance" name="balance" placeholder="Nhập số tiền" required>
                                </div>
                                <a class="btn btn-success" href="{{ route('admin.phuhuynh.index') }}">Quay Lại</a>
                                <button class="btn btn-primary" type="submit">Thực Hiện</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form class="col-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Thông Tin Gói Vip</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Gói Vip Hiện Tại</label>
                                    <input type="text" class="form-control" value="{{ empty($phuhuynh->vip_package) ? 'Chưa sử dụng VIP' : $phuhuynh->vip_package }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="slug">Chọn Gói VIP</label>
                                    <select name="action" class="form-control">
                                        <option value="add">Cộng Tiền</option>
                                        <option value="sub">Trừ Tiền</option>
                                    </select>
                                </div>
                                <a class="btn btn-success" href="{{ route('admin.phuhuynh.index') }}">Quay Lại</a>
                                <button class="btn btn-primary" type="submit">Thực Hiện</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- /.container-fluid -->
</section>
<style>
    .form-control:disabled, .form-control[readonly] {
        background-color: white;
        opacity: 1;
    }
</style>
@endsection

