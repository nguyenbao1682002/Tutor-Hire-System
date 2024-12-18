@extends('Web.layouts.app')
@section('title', 'Đăng Ký Phụ Huynh')
@section('content')
<div class="main_content shop pb-100 mt-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap widget-taber-content p-30 background-white border-radius-5">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3 class="mb-30">Làm Phụ Huynh</h3>
                        </div>
                        
                        <!-- Hiển thị lỗi nếu có -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('web.auth.parentRegister.submit') }}">
                            @csrf
                            <div class="form-group">
                                <input class="form-control" required="" type="text" name="name" placeholder="Họ tên phụ huynh">
                            </div>
                            <div class="form-group">
                                <input class="form-control" required="" type="text" name="phone" placeholder="Số điện thoại">
                            </div>
                            <div class="form-group">
                                <input class="form-control" required="" type="text" name="address" placeholder="Địa chỉ">
                            </div>
                            <div class="form-group">
                                <input type="email" required="" class="form-control" name="email" placeholder="Nhập email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <input class="form-control" required="" type="password" name="password" placeholder="Mật khẩu">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-fill-out btn-block">Đăng Ký - Làm Phụ Huynh</button>
                            </div>
                        </form>
                        <div class="text-muted text-center">Đã có tài khoản? <a href="{{ route('web.auth.login') }}">Đăng Nhập</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    main{
        background-color: #f4f5f9;
    }
</style>
@endsection