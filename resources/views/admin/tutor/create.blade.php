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
                    <li class="breadcrumb-item active"><a href="{{ route('admin.tutor.index') }}">Quản Lý Gia Sư</a>
                    </li>
                    <li class="breadcrumb-item active">Tạo Thông Tin</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Thêm Gia Sư Mới</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.tutor.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Tên Gia Sư</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Tên gia sư"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Mật khẩu" required>
                            </div>
                            <div class="form-group">
                                <label for="area">Khu vực giảng dạy</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <select id="province" name="province" class="form-control">
                                            <option value="">Chọn Tỉnh/Thành phố</option>
                                        </select>
                                        <input type="hidden" id="province_text" name="province_text">
                                    </div>
                                    <div class="col-md-4">
                                        <select id="district" name="district" class="form-control">
                                            <option value="">Chọn Quận/Huyện</option>
                                        </select>
                                        <input type="hidden" id="district_text" name="district_text">
                                    </div>
                                    <div class="col-md-4">
                                        <select id="ward" name="ward" class="form-control">
                                            <option value="">Chọn Xã/Phường</option>
                                        </select>
                                        <input type="hidden" id="ward_text" name="ward_text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fee">Phí</label>
                                <input type="number" class="form-control" id="fee" name="fee" placeholder="Phí">
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-success" href="{{ route('admin.tutor.index') }}">Quay Lại</a>
                    <button type="submit" class="btn btn-primary">Lưu Thông Tin</button>
                </form>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
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