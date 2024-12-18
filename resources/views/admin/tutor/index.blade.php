@extends('Admin.layouts.app')
@section('title', 'Quản Lý Gia Sư')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Quản Lý Gia Sư</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Quản Lý Gia Sư</li>
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
                            <form action="{{ route('admin.tutor.index') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Tìm kiếm" value="{{ request()->query('search') }}">
                                <button type="submit" class="btn btn-primary ml-2 w-50">Tìm kiếm</button>
                            </form>
                            <a href="{{ route('admin.tutor.create') }}" class="btn btn-success">Thêm Gia Sư</a>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Xếp hạng</th>
                                    <th>Lượt đánh giá</th>
                                    <th>Khu vực</th>
                                    <th>Phí dạy</th>
                                    <th>Số bài đăng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tutors as $key => $tutor)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $tutor->user->name }}</td>
                                        <td>{{ $tutor->user->email }}</td>
                                        <td>{{ $tutor->rating ?? 'N/A' }} / 5</td>
                                        <td>{{ $tutor->review_count ?? 0 }} lượt</td>
                                        <td>{{ $tutor->area ?? 'N/A' }}</td>
                                        <td>{{ number_format($tutor->fee) ?? 'N/A' }}đ / buổi</td>
                                        <td>{{ $tutor->post_status ?? 'N/A' }} bài</td>
                                        <td>
                                            <a href="{{ route('admin.tutor.edit', $tutor->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i> Cập Nhật</a>
                                            <form action="{{ route('admin.tutor.destroy', $tutor->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><i class="fa-solid fa-trash"></i> Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Không tìm thấy gia sư nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer clearfix">
                        {{ $tutors->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection