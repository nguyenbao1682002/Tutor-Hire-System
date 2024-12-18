@extends('Web.layouts.app')
@section('title', 'Phụ Huynh')
@section('content')
<div class="main_content shop pb-80">
    <div class="archive-header shop-header header-bg2 pt-50 pb-50 mb-80" style="background-image: url({{ asset('assets/imgs/theme/shop-header-bg-2.jpg') }});">
        <div class="container">
            <div class="row align-items-center h-100">
                <div class="col-md-6 mx-auto">
                    <h2><span class="color6">Cá Nhân</span></h2>
                </div>
                <div class="col-md-6 mx-auto text-center text-md-right">
                    <div class="breadcrumb">
                        <a href="{{ route('web.home.index') }}"><i class="ti-home mr-5"></i>Trang Chủ</a><span></span>
                        Cá Nhân
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row" style="min-height: 500px;">
            <div class="col-lg-3 col-md-4">
                <div class="dashboard-menu ">
                    <ul class="nav flex-column" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i class="ti-panel mr-5"></i>Bảng Điều Khiển</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="address-tab" href="{{ route('web.phuhuynh.pay') }}"><i class="fa fa-dollar-sign mr-5"></i>Nạp Tiền</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="fa fa-list-alt mr-5"></i>Lịch Sử Giao Dịch</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="account-detail-tab" data-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="ti-id-badge mr-5"></i>Cập Nhật Thông Tin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('web.auth.logout') }}"><i class="ti-lock mr-5"></i>Đăng Xuất</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="tab-content dashboard-content">
                    <div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Bảng Điều Khiển</h5>
                            </div>
                            <div class="card-body">
                                <p>Từ bảng điều khiển của phụ huynh có thể xem <a href="javascript:void(0);" onclick="$('#orders-tab').trigger('click')">lịch sử nạp tiền</a>, 
                                quản lý các thông tin và <a href="javascript:void(0);" onclick="$('#address-tab').trigger('click')">cập nhật thông tin cá nhân</a> và  
                                <a href="{{ route('web.phuhuynh.pay') }}">nạp tiền vào tài khoản hệ thống!</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Giao Dịch Gần Đây</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Số Tiền</th>
                                                <th>Mô Tả</th>
                                                <th>Thời Gian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($transactions as $key => $transaction)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ number_format($transaction->amount, 0, ',', '.') }} VNĐ</td>
                                                    <td>{{ $transaction->description }}</td>
                                                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">Không có giao dịch nào!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="pagination-area pt-30 text-center bt-1 border-color-1">
                                        {{ $transactions->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-3 mb-lg-0">
                                    <div class="card-header">
                                        <h5 class="mb-0">Billing Address</h5>
                                    </div>
                                    <div class="card-body">
                                        <address>3522 Interstate<br> 75 Business Spur,<br> Sault Ste. <br>Marie, MI 49783</address>
                                        <p>New York</p>
                                        <a href="#" class="btn btn-fill-out btn-small">Edit</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Shipping Address</h5>
                                    </div>
                                    <div class="card-body">
                                        <address>4299 Express Lane<br>
                                            Sarasota, <br>FL 34249 USA <br>Phone: 1.941.227.4444</address>
                                        <p>Sarasota</p>
                                        <a href="#" class="btn btn-fill-out btn-small">Edit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                        <div class="card">
                            <div class="card-header">
                                <h3>Thông Tin Phụ Huynh</h3>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('web.phuhuynh.update') }}">
                                    <div class="row">
                                        @csrf
                                        <div class="form-group col-md-12">
                                            <input class="form-control" required="" type="text" name="name" placeholder="Họ tên phụ huynh" value="{{ $user->name }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input class="form-control" required="" type="text" name="phone" placeholder="Số điện thoại" value="{{ $user->phone }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input class="form-control" required="" type="text" name="address" placeholder="Địa chỉ" value="{{ $phuhuynh->address }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="email" required="" class="form-control" name="email" placeholder="Nhập email" value="{{ $user->email }}">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <input class="form-control" type="password" name="old_password" placeholder="Mật khẩu cũ">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input class="form-control" type="password" name="password" placeholder="Mật khẩu">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input class="form-control" type="password" name="password2" placeholder="Xác nhận mật khẩu">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-fill-out" name="submit" value="Submit">Lưu Thông Tin</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
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
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            $(document).ready(function () {
                Toastify({
                    text: '{{ $error }}',
                    duration: 5000, // thời gian hiển thị (ms)
                    close: true, // nút đóng
                    gravity: "top", // vị trí: "top" hoặc "bottom"
                    position: "center", // "left", "center", "right"
                }).showToast();
            });
        </script>
    @endforeach
@endif
@endsection
