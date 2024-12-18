@extends('Admin.layouts.app')
@section('title', 'Cập Nhật Gia Sư')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cập Nhật Gia Sư</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tutor.index') }}">Quản Lý Gia Sư</a></li>
                    <li class="breadcrumb-item active">Cập Nhật</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Cập Nhật Thông Tin Gia Sư</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.tutor.update', $tutor->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Tên Gia Sư</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Tên gia sư" value="{{ $tutor->user->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $tutor->user->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu (để trống nếu không thay đổi)</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
                            </div>
                            <div class="form-group">
                                <label for="area">Khu vực giảng dạy</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <select id="province" name="province" class="form-control">
                                            <option value="{{ $tutor->province }}" hidden>
                                                @if (count(explode(', ',$tutor->area)) == 2)
                                                    {{ explode(', ',$tutor->area)[1] }}
                                                
                                                @else
                                                    {{ explode(', ',$tutor->area)[2] }}
                                                @endif
                                            </option>
                                        </select>
                                        @if (count(explode(', ',$tutor->area)) == 2)
                                            <input type="hidden" id="province_text" name="province_text" value="{{ explode(', ',$tutor->area)[1] }}">
                                        @else
                                            <input type="hidden" id="province_text" name="province_text" value="{{ explode(', ',$tutor->area)[2] }}">
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <select id="district" name="district" class="form-control">
                                            <option value="{{ $tutor->district }}" hidden>
                                                @if (count(explode(', ',$tutor->area)) == 2)
                                                    {{ explode(', ',$tutor->area)[0] }}
                                                @else
                                                    {{ explode(', ',$tutor->area)[1] }}
                                                @endif
                                            </option>
                                        </select>
                                        @if (count(explode(', ',$tutor->area)) == 2)
                                            <input type="hidden" id="district_text" name="district_text" value="{{ explode(', ',$tutor->area)[0] }}">
                                        @else
                                            <input type="hidden" id="district_text" name="district_text" value="{{ explode(', ',$tutor->area)[1] }}">
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <select id="ward" name="ward" class="form-control">
                                            <option value="{{ $tutor->ward }}" hidden>
                                                @if (count(explode(', ',$tutor->area)) == 2)
                                                    Chọn Xã/Phường
                                                @else
                                                    {{ explode(', ',$tutor->area)[0] }}
                                                @endif
                                            </option>
                                        </select>
                                        @if (count(explode(', ',$tutor->area)) == 2)
                                            <input type="hidden" id="ward_text" name="ward_text" value="">
                                        @else
                                            <input type="hidden" id="ward_text" name="ward_text" value="{{ explode(', ',$tutor->area)[0] }}">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="education_level">Trình độ</label>
                                        <select id="education_level" name="education_level" class="form-control">
                                            <option value="Sinh Viên" {{ $tutor->education_level == 'Sinh Viên' ? 'selected' : '' }}>Sinh Viên</option>
                                            <option value="Cử Nhân" {{ $tutor->education_level == 'Cử Nhân' ? 'selected' : '' }}>Cử Nhân</option>
                                            <option value="Thạc Sĩ" {{ $tutor->education_level == 'Thạc Sĩ' ? 'selected' : '' }}>Thạc Sĩ</option>
                                            <option value="Kỹ Sư" {{ $tutor->education_level == 'Kỹ Sư' ? 'selected' : '' }}>Kỹ Sư</option>
                                            <option value="Chuyên Gia" {{ $tutor->education_level == 'Chuyên Gia' ? 'selected' : '' }}>Chuyên Gia</option>
                                            <option value="Giáo Viên" {{ $tutor->education_level == 'Giáo Viên' ? 'selected' : '' }}>Giáo Viên</option>
                                            <option value="Tiến Sĩ" {{ $tutor->education_level == 'Tiến Sĩ' ? 'selected' : '' }}>Tiến Sĩ</option>
                                            <option value="Giáo Sư" {{ $tutor->education_level == 'Giáo Sư' ? 'selected' : '' }}>Giáo Sư</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="years_of_experience">Kinh nghiệm (năm)</label>
                                        <input type="number" class="form-control" id="years_of_experience" name="years_of_experience" placeholder="Số năm kinh nghiệm" value="{{ $tutor->years_of_experience }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="fee">Phí</label>
                                        <input type="number" class="form-control" id="fee" name="fee" placeholder="Phí" value="{{ $tutor->fee }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="balance">Số dư</label>
                                <input type="text" class="form-control" id="balance" placeholder="Số dư" value="{{ number_format($tutor->balance) }}đ" disabled>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-success" href="{{ route('admin.tutor.index') }}">Quay Lại</a>
                    <button type="submit" class="btn btn-primary">Lưu Thông Tin</button>
                </form>
            </div>
        </div>
        <div class="row">
            <form class="col-6" method="POST", action="{{ route('admin.phuhuynh.balance', $tutor->id) }}">
                @csrf
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Thông Tin Số Dư</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="slug">Hành Động</label>
                                    <select name="action" class="form-control">
                                        <option value="add">Cộng Tiền</option>
                                        <option value="sub">Trừ Tiền</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="blance">Số Tiền</label>
                                    <input type="number" class="form-control" id="blance" name="balance" placeholder="Nhập số tiền" required>
                                </div>
                                <button class="btn btn-primary" type="submit">Thực Hiện</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form class="col-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Thông Tin Gói Vip</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Gói Vip Hiện Tại</label>
                                    <input type="text" class="form-control" value="{{ empty($tutor->vip_package) ? 'Chưa sử dụng VIP' : $tutor->vip_package }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="slug">Chọn Gói VIP</label>
                                    <select name="action" class="form-control">
                                        <option value="add">Cộng Tiền</option>
                                        <option value="sub">Trừ Tiền</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" type="submit">Thực Hiện</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Load danh sách Tỉnh/Thành phố khi trang được tải
        fetch('/api/province')
            .then(response => response.json())
            .then(data => {
                let provinceSelect = document.getElementById('province');
                data.results.forEach(province => {
                    let option = document.createElement('option');
                    option.value = province.province_id; // Giữ nguyên value
                    option.textContent = province.province_name; // Giá trị text
                    provinceSelect.appendChild(option);
                });
                // Set giá trị đã chọn từ database
                provinceSelect.value = "{{ $tutor->province }}"; // Giả định province là id
            });

        document.getElementById('province').addEventListener('change', function () {
            let provinceId = this.value; // Lấy province_id
            let districtSelect = document.getElementById('district');
            districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';

            fetch(`/api/district/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    data.results.forEach(district => {
                        let option = document.createElement('option');
                        option.value = district.district_id; // Giữ nguyên value
                        option.textContent = district.district_name; // Giá trị text
                        districtSelect.appendChild(option);
                    });
                });

            document.getElementById('ward').innerHTML = '<option value="">Chọn Xã/Phường</option>';
            document.getElementById('province_text').value = this.options[this.selectedIndex].textContent; // Lưu giá trị text
        });

        document.getElementById('district').addEventListener('change', function () {
            let districtId = this.value; // Lấy district_id
            let wardSelect = document.getElementById('ward');
            wardSelect.innerHTML = '<option value="">Chọn Xã/Phường</option>';

            fetch(`/api/ward/${districtId}`)
                .then(response => response.json())
                .then(data => {
                    data.results.forEach(ward => {
                        let option = document.createElement('option');
                        option.value = ward.ward_id; // Giữ nguyên value
                        option.textContent = ward.ward_name; // Giá trị text
                        wardSelect.appendChild(option);
                    });
                });

            document.getElementById('district_text').value = this.options[this.selectedIndex].textContent; // Lưu giá trị text
            document.getElementById('ward_text').value = ''; // Reset giá trị text của ward
        });

        document.getElementById('ward').addEventListener('change', function () {
            let wardId = this.value; // Lấy ward_id
            document.getElementById('ward_text').value = this.options[this.selectedIndex].textContent; // Lưu giá trị text
        });
    });
</script>
@endsection
