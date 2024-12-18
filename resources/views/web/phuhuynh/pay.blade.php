@extends('Web.layouts.app')
@section('title', 'Nạp Tiền')
@section('content')
<div class="main_content shop pb-100 mt-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-md-10">
                <div class="login_wrap widget-taber-content p-30 background-white border-radius-5">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3 class="mb-30 text-center">Nạp Tiền - Chuyển Khoản</h3>
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

                        <form method="POST" action="{{ route('web.phuhuynh.payCheck') }}">
                            @csrf
                            <div class="form-group">
                                <label for="">Họ Tên</label>
                                <input type="text" disabled required="" class="form-control" placeholder="Người dùng" value="{{ auth()->user()->name }}">
                            </div>
                            @php
                                $phuHuynhCommon = \App\Models\PhuHuynh::where('user_id', auth()->user()->id)->first();
                            @endphp
                            <div class="form-group">
                                <label for="">Số Dư Hiện Tại</label>
                                <input type="text" disabled required="" class="form-control" placeholder="Số dư hiện tại" value="{{ number_format($phuHuynhCommon->balance) }} VNĐ">
                            </div>
                            <div class="form-group">
                                <label for="">Số Tiền Nạp</label>
                                <input min="5000" class="form-control" required="" type="number" name="amount" placeholder="Số tiền nạp">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-fill-out btn-block" name="login">Nạp Tiền</button>
                            </div>
                        </form>
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
    .form-control:disabled, .form-control[readonly] {
        background-color: white;
        opacity: 1;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endsection
@section('script')
@if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function () {
            Toastify({
                text: '{{ session('success') }}',
                duration: 5000, // thời gian hiển thị (ms)
                close: true, // nút đóng
                gravity: "bottom", // vị trí: "top" hoặc "bottom"
                position: "center", // "left", "center", "right"
            }).showToast();
        });
    </script>
@endif
@endsection
