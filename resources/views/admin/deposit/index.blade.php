@extends('Admin.layouts.app')
@section('title', 'Quản Lý Nạp Tiền')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Quản Lý Nạp Tiền</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Nạp Tiền</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <form class="card card-default" method="POST" action="{{ route('admin.deposit.pay') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Nạp Tiền Vào Tài Khoản</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Người Dùng</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" placeholder="Tên người dùng" disabled>
                        </div>
                        <div class="form-group">
                            <label for="slug">Số Dư Hiện Tại (VND)</label>
                            <input type="text" class="form-control" value="{{ number_format($balance) }} VND" placeholder="Số dư hiện tại" disabled>
                        </div>
                        <div class="form-group">
                            <label for="name">Số Tiền Nạp (VND)</label>
                            <input type="number" class="form-control" name="sotien" placeholder="Nhập số tiền">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Nạp Tiền</button>
            </div>
        </form>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lịch Sử Nạp Tiền</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
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
                                <td colspan="6" class="text-center">Không có giao dịch nào!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $transactions->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<style>
    .form-control:disabled, .form-control[readonly] {
        background-color: white;
        opacity: 1;
        cursor: not-allowed;
    }
</style>
@endsection
