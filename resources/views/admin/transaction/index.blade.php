@extends('Admin.layouts.app')
@section('title', 'Quản Lý Giao Dịch')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Quản Lý Giao Dịch</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Giao Dịch</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="{{ route('admin.transaction.index') }}" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên, email" value="{{ $search }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Tìm Kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Người Dùng</th>
                            <th>Email</th>
                            <th>Số Tiền</th>
                            <th>Mô Tả</th>
                            <th>Thời Gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->user->name }}</td>
                                <td>{{ $transaction->user->email }}</td>
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
@endsection
