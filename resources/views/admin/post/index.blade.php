@extends('Admin.layouts.app')
@section('title', 'Quản Lý Bài Viết')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Quản Lý Bài Viết</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Quản Lý Bài Viết</li>
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
                            <form action="{{ route('admin.post.index') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Tìm kiếm" value="{{ request()->query('search') }}">
                                <button type="submit" class="btn btn-primary ml-2 w-50">Tìm kiếm</button>
                            </form>
                            @if(auth()->user()->role == "gia_su")
                                <a href="{{ route('admin.post.create') }}" class="btn btn-success">
                                    Thêm Bài Viết 
                                    @if ($checkVip == false)
                                        (Chưa Mua Vip)
                                    @endif
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Hình Ảnh</th>
                                    <th>Tiêu Đề</th>
                                    @if (auth()->user()->role == "admin")
                                        <th>Người Đăng</th>
                                    @endif
                                    <th>Môn Học</th>
                                    <th>Chi Phí</th>
                                    <th>Trạng Thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $key => $post)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <img style="width: 150px; height:150px;" src="{{ asset('storage/' . $post->image) ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png' }}" alt="">
                                        </td>
                                        <td>{{ $post->title }}</td>
                                        @if (auth()->user()->role == "admin")
                                            <td>
                                                <a href="{{ route('admin.tutor.edit', $post->giaSu->id) }}">{{ $post->giaSu->user->name ?? 'N/A' }}</a>
                                            </td>
                                        @endif
                                        <td>{{ $post->subject->name ?? 'N/A' }}</td>
                                        
                                        <td>{{ number_format($post->fee) }}đ</td>
                                        <td>
                                        @if (auth()->user()->role == "admin")
                                            @if ($post->status == "pending")
                                                <form action="{{ route('admin.post.update', $post->id) }}" method="POST"
                                                style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" value="accept" name="status">
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                    ><i class="fas fa-check-circle"></i> Phê Duyệt</button>
                                                </form>
                                                <form action="{{ route('admin.post.update', $post->id) }}" method="POST"
                                                style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" value="reject" name="status">
                                                    <button type="submit" class="btn btn-sm btn-dark"
                                                    ><i class="fas fa-times-circle"></i> Từ Chối</button>
                                                </form>
                                            @elseif($post->status == "reject")
                                                Đã từ chối
                                            @else
                                                <b>Đã phê duyệt</b>
                                            @endif
                                        @else
                                            @if ($post->status == "pending")
                                                <b style="color: red;">Đang chờ duyệt</b>
                                            @elseif($post->status == "reject")
                                                Đã từ chối
                                            @else
                                                <b>Đã phê duyệt</b>
                                            @endif
                                        @endif
                                        </td>
                                        <td>
                                            @if (auth()->user()->role == "admin")
                                                <a href="{{ route('admin.post.show', $post->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fa-regular fa-eye"></i> Xem Chi Tiết</a>
                                            @else
                                                <a href="{{ route('admin.post.show', $post->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i></i> Chỉnh Sửa</a>
                                            @endif
                                            <form action="{{ route('admin.post.destroy', $post->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><i class="fa-solid fa-trash"></i> Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không tìm thấy bài viết nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer clearfix">
                        {{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection