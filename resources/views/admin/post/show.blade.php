@extends('Admin.layouts.app')
@section('title', 'Xem Bài Viết')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Xem Bài Viết</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.post.index') }}">Quản Lý Bài Viết</a></li>
                    <li class="breadcrumb-item active">Xem Bài Viết</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <form class="row" method="POST" enctype="multipart/form-data" action="{{ route('admin.post.update', $post->id) }}">
            @csrf
            @method('PUT')
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Nội Dung Bài Viết</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea id="content" class="form-control" name="description">{{ $post->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Thông Tin Bài Viết</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if (auth()->user()->role == "admin")
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Tiêu đề</label>
                                        <input type="text" class="form-control" placeholder="Tiêu đề" value="{{ $post->title }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Đường dẫn</label>
                                        <input type="text" class="form-control" placeholder="Đường dẫn" value="{{ $post->slug }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Môn học</label>
                                        <input type="text" class="form-control" placeholder="Môn học" value="{{ $post->subject->name }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="fee">Mức phí</label>
                                        <input type="number" class="form-control" placeholder="Mức phí" value="{{ $post->fee }}" disabled>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Tiêu đề</label>
                                        <input type="text" class="form-control" name="title" placeholder="Tiêu đề" value="{{ $post->title }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Đường dẫn</label>
                                        <input type="text" class="form-control" name="slug" placeholder="Đường dẫn" value="{{ $post->slug }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Môn học</label>
                                        <select name="subject_id" class="form-control">
                                            @foreach ($subjects as $subject)
                                                @if ($subject->id == $post->subject->id)
                                                    <option value="{{ $subject->id }}" selected>{{ $subject->name }}</option>
                                                @else
                                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="fee">Mức phí</label>
                                        <input type="number" class="form-control" name="fee" placeholder="Mức phí" value="{{ $post->fee }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="fee">Hình Ảnh</label>
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <a class="btn btn-success" href="{{ route('admin.post.index') }}">Quay Lại</a>
                        <button class="btn btn-primary" type="submit">Lưu Bài Viết</button>
                    </div>
                </div>
            </div>
        </form>
        
    </div><!-- /.container-fluid -->
</section>
<style>
    .form-control:disabled, .form-control[readonly] {
        background-color: white;
        opacity: 1;
    }
</style>
@endsection
@section('script')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });

    $(document).ready(function() {
        function createSlug(name) {
            return name.toLowerCase()
                .replace(/á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/g, 'a')
                .replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/g, 'e')
                .replace(/i|í|ì|ỉ|ĩ|ị/g, 'i')
                .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/g, 'o')
                .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/g, 'u')
                .replace(/ý|ỳ|ỷ|ỹ|ỵ/g, 'y')
                .replace(/đ/g, 'd')
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, ''); // Trim - from end of text
        }

        $('input[name="title"]').on('keyup', function() {
            var title = $(this).val();
            $('input[name="slug"]').val(createSlug(title));
        });
    });
</script>
@endsection
