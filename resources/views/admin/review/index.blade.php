@extends('Admin.layouts.app')
@section('title', 'Quản Lý Đánh Giá')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Quản Lý Đánh Giá</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Quản Lý Đánh Giá</li>
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
                            <form action="{{ route('admin.review.index') }}" method="GET" class="d-flex">
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
                                    <th>Phụ Huynh</th>
                                    @if(auth()->user()->role == "admin")
                                        <th>Gia Sư</th>
                                    @endif
                                    <th>Đánh Giá</th>
                                    @if(auth()->user()->role == "admin")
                                        <th>Hành Động</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $key => $review)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><a href="{{ route('admin.phuhuynh.show', $review->phuHuynh->id) }}">{{ $review->phuHuynh->user->name ?? 'N/A' }}</a></td>
                                        @if(auth()->user()->role == "admin")
                                            <td><a href="{{ route('admin.tutor.edit', $review->giaSu->id) }}">{{ $review->giaSu->user->name ?? 'N/A' }}</a></td>
                                        @endif
                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <i class="fa-solid fa-star" style="color: gold;"></i>
                                                @else
                                                    <i class="fa-regular fa-star" style="color: #d3d3d3;"></i>
                                                @endif
                                            @endfor
                                        </td>
                                        @if(auth()->user()->role == "admin")
                                            <td>
                                                <form action="{{ route('admin.review.destroy', $review->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                        <i class="fa-solid fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Không tìm thấy đánh giá nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer clearfix">
                        {{ $reviews->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection