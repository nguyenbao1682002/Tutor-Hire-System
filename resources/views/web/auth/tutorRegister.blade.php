@extends('Web.layouts.app')
@section('title', 'Đăng Ký Gia Sư')
@section('content')
<div class="main_content shop pb-100 mt-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-md-10">
                <div class="login_wrap widget-taber-content p-30 background-white border-radius-5">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3 class="mb-30">Làm Gia Sư</h3>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('web.auth.tutorRegister.submit') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="area">Họ Tên</label>
                                        <input class="form-control" required="" type="text" name="name" placeholder="Họ tên gia sư" value="{{ old('name') }}">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="area">Số Điện Thoại</label>
                                        <input class="form-control" required="" type="text" name="phone" placeholder="Số điện thoại" value="{{ old('phone') }}">
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="area">Email</label>
                                        <input type="email" required="" class="form-control" name="email" placeholder="Nhập email" value="{{ old('email') }}">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="area">Mật Khẩu</label>
                                        <input class="form-control" required="" type="password" name="password" placeholder="Mật khẩu">
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="area">Khu vực giảng dạy</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <select id="province" name="province" class="form-control w-100" style="display: unset;">
                                            <option value="">Chọn Tỉnh/Thành phố</option>
                                        </select>
                                        <input type="hidden" id="province_text" name="province_text">
                                        @error('province')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <select id="district" name="district" class="form-control w-100">
                                            <option value="">Chọn Quận/Huyện</option>
                                        </select>
                                        <input type="hidden" id="district_text" name="district_text">
                                        @error('district')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <select id="ward" name="ward" class="form-control w-100">
                                            <option value="">Chọn Xã/Phường</option>
                                        </select>
                                        <input type="hidden" id="ward_text" name="ward_text">
                                        @error('ward')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="fee">Mức Phí Tối Thiểu</label>
                                        <input type="number" class="form-control" id="fee" name="fee" placeholder="Phí" value="{{ old('fee') }}">
                                        @error('fee')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="years_of_experience">Số năm kinh nghiệm</label>
                                        <select id="years_of_experience" name="years_of_experience" class="form-control w-100">
                                            <option value="1" {{ old('years_of_experience') == 1 ? 'selected' : '' }}>1 năm</option>
                                            <option value="2" {{ old('years_of_experience') == 2 ? 'selected' : '' }}>2 năm</option>
                                            <option value="3" {{ old('years_of_experience') == 3 ? 'selected' : '' }}>3 năm</option>
                                            <option value="4" {{ old('years_of_experience') == 4 ? 'selected' : '' }}>4 năm</option>
                                            <option value="5" {{ old('years_of_experience') == 5 ? 'selected' : '' }}>5 năm</option>
                                        </select>
                                        @error('years_of_experience')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="education_level">Trình Độ</label>
                                        <select id="education_level" name="education_level" class="form-control w-100">
                                            <option value="Sinh Viên" {{ old('education_level') == 'Sinh Viên' ? 'selected' : '' }}>Sinh Viên</option>
                                            <option value="Cử Nhân" {{ old('education_level') == 'Cử Nhân' ? 'selected' : '' }}>Cử Nhân</option>
                                            <option value="Thạc Sĩ" {{ old('education_level') == 'Thạc Sĩ' ? 'selected' : '' }}>Thạc Sĩ</option>
                                            <option value="Kỹ Sư" {{ old('education_level') == 'Kỹ Sư' ? 'selected' : '' }}>Kỹ Sư</option>
                                            <option value="Chuyên Gia" {{ old('education_level') == 'Chuyên Gia' ? 'selected' : '' }}>Chuyên Gia</option>
                                            <option value="Giáo Viên" {{ old('education_level') == 'Giáo Viên' ? 'selected' : '' }}>Giáo Viên</option>
                                            <option value="Tiến Sĩ" {{ old('education_level') == 'Tiến Sĩ' ? 'selected' : '' }}>Tiến Sĩ</option>
                                            <option value="Giáo Sư" {{ old('education_level') == 'Giáo Sư' ? 'selected' : '' }}>Giáo Sư</option>
                                        </select>
                                        @error('education_level')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="avatar">Ảnh Thẻ</label>
                                <input type="file" class="form-control" id="avatar" name="avatar">
                                @error('avatar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="bio">Giới Thiệu</label>
                                <textarea class="form-control" name="bio" id="bio" placeholder="Giới thiệu không quá 150 từ" rows="5">{{ old('bio') }}</textarea>
                                @error('bio')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-fill-out btn-block">Đăng Ký - Làm Gia Sư</button>
                            </div>
                        </form>

                        <div class="text-muted text-center">Đã có tài khoản? <a href="{{ route('web.auth.login') }}">Đăng Nhập</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    main{
        background-color: #f4f5f9;
    }
</style>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        // Load danh sách Tỉnh/Thành phố khi trang được tải
        $(".nice-select").css("display", "none");
        $("#province").css("display", "unset");
        $("#district").css("display", "unset");
        $("#ward").css("display", "unset");
        $("#years_of_experience").css("display", "unset");
        $("#education_level").css("display", "unset");
        $.getJSON('/api/province', function (data) {
            let $provinceSelect = $('#province');
            data.results.forEach(function (province) {
                $provinceSelect.append($('<option>', {
                    value: province.province_id,
                    text: province.province_name
                }));
            });
        });

        // Khi thay đổi Tỉnh/Thành phố
        $('#province').on('change', function () {
            let provinceId = $(this).val();
            let $districtSelect = $('#district');
            $districtSelect.html('<option value="">Chọn Quận/Huyện</option>'); // Reset danh sách Quận/Huyện

            if (provinceId) {
                $.getJSON(`/api/district/${provinceId}`, function (data) {
                    data.results.forEach(function (district) {
                        $districtSelect.append($('<option>', {
                            value: district.district_id,
                            text: district.district_name
                        }));
                    });
                });
            }

            $('#ward').html('<option value="">Chọn Xã/Phường</option>'); // Reset danh sách Xã/Phường
            $('#province_text').val($(this).find('option:selected').text()); // Lưu giá trị text của tỉnh
        });

        // Khi thay đổi Quận/Huyện
        $('#district').on('change', function () {
            let districtId = $(this).val();
            let $wardSelect = $('#ward');
            $wardSelect.html('<option value="">Chọn Xã/Phường</option>'); // Reset danh sách Xã/Phường

            if (districtId) {
                $.getJSON(`/api/ward/${districtId}`, function (data) {
                    data.results.forEach(function (ward) {
                        $wardSelect.append($('<option>', {
                            value: ward.ward_id,
                            text: ward.ward_name
                        }));
                    });
                });
            }

            $('#district_text').val($(this).find('option:selected').text()); // Lưu giá trị text của quận
            $('#ward_text').val(''); // Reset giá trị text của xã
        });

        // Khi thay đổi Xã/Phường
        $('#ward').on('change', function () {
            $('#ward_text').val($(this).find('option:selected').text()); // Lưu giá trị text của xã
        });
    });
</script>
@endsection
