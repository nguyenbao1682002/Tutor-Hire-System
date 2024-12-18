@extends('Admin.layouts.app')
@section('title', 'Thông Tin Cá Nhân')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Thông Tin Cá Nhân</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Thông Tin Cá Nhân</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        {{-- Form chỉnh sửa thông tin --}}
        <form class="card card-default" method="POST" action="{{ route('admin.profile.update') }}">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Thông Tin Cá Nhân</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Họ và tên">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Email">
                </div>
                <button type="submit" class="btn btn-primary">Lưu Thông Tin</button>
            </div>
        </form>

        <hr>

        {{-- Form đổi mật khẩu --}}
        <form class="card card-default mt-3" method="POST" action="{{ route('admin.profile.changePassword') }}">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Đổi Mật Khẩu</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="current_password">Mật khẩu hiện tại</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Mật khẩu hiện tại">
                </div>
                <div class="form-group">
                    <label for="new_password">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Mật khẩu mới">
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Xác nhận mật khẩu mới">
                </div>
                <button type="submit" class="btn btn-danger">Đổi Mật Khẩu</button>
            </div>
        </form>
    </div>
</section>
<style>
    .form-control:disabled, .form-control[readonly] {
        background-color: white;
        opacity: 1;
    }
</style>
@endsection
