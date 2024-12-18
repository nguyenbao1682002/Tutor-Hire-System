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
                    <li class="breadcrumb-item active">Quản Lý Phụ Huynh</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <form action="{{ route('admin.phuhuynh.index') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Tìm kiếm" value="{{ request()->query('search') }}">
                                <button type="submit" class="btn btn-primary ml-2 w-50">Tìm kiếm</button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Địa Chỉ</th>
                                    <th>Gói Vip</th>
                                    <th>Số Dư</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($phuhuynhs as $key => $phuhuynh)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $phuhuynh->user->name }}</td>
                                        <td>{{ $phuhuynh->user->email }}</td>
                                        <td>{{ $phuhuynh->phone_number }}</td>
                                        <td>{{ $phuhuynh->address }}</td>
                                        <td>{{ empty($phuhuynh->vip_package) ? 'Chưa sử dụng VIP' : $phuhuynh->vip_package }}</td>
                                        <td>{{ number_format($phuhuynh->balance) }}đ</td>
                                        <td>
                                            <a href="{{ route('admin.phuhuynh.show', $phuhuynh->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i> Cập Nhật</a>
                                            @if ($phuhuynh->status == 1)
                                                <a href="{{ route('admin.phuhuynh.block', $phuhuynh->id) }}"
                                                class="btn btn-sm btn-danger"><i class="fa-solid fa-user-lock"></i> Cấm Dùng</a>
                                            @else
                                                <a href="{{ route('admin.phuhuynh.block', $phuhuynh->id) }}"
                                                class="btn btn-sm btn-success"><i class="fa-solid fa-unlock"></i> Bỏ Cấm</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Không tìm thấy phụ huynh nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer clearfix">
                        {{ $phuhuynhs->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection