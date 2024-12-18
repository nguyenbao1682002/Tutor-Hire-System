@extends('Web.layouts.app')
@section('title', 'Thông Tin Gia Sư')
@section('content')
<!-- Bootstrap Bundle JS (bao gồm Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<div class="main_content sidebar_right pb-50">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!--author box-->
                <div class="author-bio mb-50" style="margin: 0; padding: 50px; border: 0; background: #f4f5f9; border-radius: 5px;">
                    <div class="author-image mb-30">
                        <a href="{{ route('web.giasu.show',$giasu->user->id ) }}"><img src="{{ empty($giasu->avatar) ? asset('assets/imgs/avatar.png'): asset('storage/' . $giasu->avatar) }}" alt="" class="avatar"></a>
                    </div>
                    <div class="author-info">
                        <h3>
                            <span class="vcard author"><span class="fn"><a href="{{ route('web.giasu.show',$giasu->user->id ) }}" title="Posts by Robert" rel="author">{{ $giasu->user->name }}</a></span></span>
                        </h3>
                        <div class="star-rating">
                            @php
                                $filledStars = $averageRating; // Số sao vàng
                                $emptyStars = 5 - $filledStars; // Số sao sẫm màu
                            @endphp

                            <!-- Hiển thị sao vàng -->
                            @for ($i = 0; $i < $filledStars; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor

                            <!-- Hiển thị sao sẫm màu -->
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="fas fa-star text-secondary"></i>
                            @endfor
                            ({{ $countRating }} đánh giá)
                        </div>
                        <br>
                        <h5>Thông Tin Giới Thiệu</h5>
                        <div class="author-description">{{ $giasu->bio }}</div>
                        <h5>Khu Vực Gia Sư</h5>
                        <div class="author-description"><i class="ti-location-pin"></i> {{ $giasu->area }}</div>
                        <h5>Số Điện Thoại</h5>
                        @php
                            $phone = $giasu->user->phone;
                            $formattedPhone = substr($phone, 0, 2) . str_repeat('*', strlen($phone) - 4) . substr($phone, -2);
                        @endphp
                        <div class="author-description phone-text1"><i class="fas fa-phone"></i> {{ $formattedPhone }}</div>
                        @if (auth()->user() && (auth()->user()->id == $giasu->user->id))
                            <a href="{{ route('admin.dashboard') }}" class="author-bio-link mb-15">truy cập quản lý</a>
                        @else
                            <a href="#" class="author-bio-link mb-15 show-phone">Xem liên hệ</a>
                            <a href="#" class="author-bio-link mb-15" data-bs-toggle="modal" data-bs-target="#reviewModal">Đánh giá</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="related-posts">
                    <div class="loop-list">
                        @foreach ($posts as $post)
                            <article class="row mb-50">
                                <div class="col-md-6">
                                    <div class="post-thumb position-relative thumb-overlay mr-20">
                                        <div class="img-hover-slide border-radius-5 position-relative"
                                            style="background-image: url('{{ asset('storage/' . $post->image) }}')">
                                            <a class="img-link" href="{{ route('web.post.show', $post->slug) }}"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 align-center-vertical">
                                    <div class="post-content">
                                        <div class="entry-meta meta-0 font-small mb-15">
                                            <a href="{{ route('web.subject.show', $post->subject->slug) }}">
                                                <span
                                                    class="post-cat background2 color-white">{{ $post->subject->name ?? 'Chưa có môn học' }}</span>
                                            </a>
                                        </div>
                                        <h4 class="post-title">
                                            <a href="{{ route('web.post.show', $post->slug) }}">{{ $post->title }}</a>
                                        </h4>
                                        <div class="entry-meta meta-1 font-small color-grey mt-15 mb-15">
                                            <span class="time-reading"><i class="ti-user"></i>
                                                <a href="{{ route('web.giasu.show', $post->giaSu->user->id) }}">{{ $post->giaSu->user->name ?? 'Không xác định' }}</a>
                                            </span>
                                            <span class="post-on"><i
                                                    class="ti-marker-alt"></i>{{ $post->created_at->format('d M Y') }}</span>
                                            <span class="time-reading"><i class="ti-timer"></i>{{ number_format($post->fee) }} VND</span>
                                        </div>
                                        <p class="font-medium">{{ strip_tags(Str::limit($post->description, 150)) }}</p>
                                        <a class="readmore-btn font-small text-uppercase font-weight-ultra"
                                            href="{{ route('web.post.show', $post->slug) }}">
                                            Đọc Thêm<i class="ti-arrow-right ml-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
                <div class="pagination-area pt-30 text-center bt-1 border-color-1">
                    {{ $posts->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <!--col-lg-8-->
            <!--Right sidebar-->
            <div class="col-lg-4 col-md-12 col-sm-12 primary-sidebar sticky-sidebar">
                <div class="widget-area pl-30">
                    <!--Widget social-->
                    <div class="sidebar-widget widget-social-network mb-50">
                        <div class="widget-header position-relative mb-20 pb-10">
                            <h5 class="widget-title mb-10">Theo Dõi</h5>
                            <div class="bt-1 border-color-1"></div>
                        </div>
                        <div class="social-network">
                            <div class="follow-us d-flex align-items-center">
                                <a class="follow-us-facebook clearfix mr-5 mb-10" href="#" target="_blank">
                                    <div class="social-icon">
                                        <i class="ti-facebook mr-5 v-align-space"></i>
                                        <i class="ti-facebook mr-5 v-align-space nth-2"></i>
                                    </div>
                                    <span class="social-name">Facebook</span>
                                    <span class="social-count counter-number">65</span><span class="social-count">K</span>
                                </a>
                                <a class="follow-us-twitter clearfix ml-5 mb-10" href="#" target="_blank">
                                    <div class="social-icon">
                                        <i class="ti-twitter-alt mr-5 v-align-space"></i>
                                        <i class="ti-twitter-alt mr-5 v-align-space nth-2"></i>
                                    </div>
                                    <span class="social-name">Twitter</span>
                                    <span class="social-count counter-number">75</span><span class="social-count">K</span>
                                </a>
                            </div>
                            <div class="follow-us d-flex align-items-center">
                                <a class="follow-us-instagram clearfix mr-5" href="#" target="_blank">
                                    <div class="social-icon">
                                        <i class="ti-instagram mr-5 v-align-space"></i>
                                        <i class="ti-instagram mr-5 v-align-space nth-2"></i>
                                    </div>
                                    <span class="social-name">Instagram</span>
                                    <span class="social-count counter-number">32</span><span class="social-count">K</span>
                                </a>
                                <a class="follow-us-youtube clearfix ml-5" href="#" target="_blank">
                                    <div class="social-icon">
                                        <i class="ti-youtube mr-5 v-align-space"></i>
                                        <i class="ti-youtube mr-5 v-align-space nth-2"></i>
                                    </div>
                                    <span class="social-name">Youtube</span>
                                    <span class="social-count counter-number">28</span><span class="social-count">K</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--Widget latest posts style 1-->
                    <div class="sidebar-widget widget_alitheme_lastpost mb-50">
                        <div class="widget-header position-relative mb-20 pb-10">
                            <h5 class="widget-title mb-10">Bài Viết Mới</h5>
                            <div class="bt-1 border-color-1"></div>
                        </div>
                        <div class="row">
                            @foreach ($newPost as $post)
                                <div class="col-md-6 col-sm-6 sm-grid-content mb-30">
                                    <div class="post-thumb d-flex border-radius-5 img-hover-scale mb-15">
                                        <a href="{{ route('web.post.show', $post->slug) }}">
                                            <img src="{{ asset('storage/' . $post->image) }}" alt="">
                                        </a>
                                    </div>
                                    <div class="post-content media-body">
                                        <h6 class="post-title mb-10 text-limit-2-row"><a href="{{ route('web.post.show', $post->slug) }}">{{ $post->title }}</a> </h6>
                                        <div class="entry-meta meta-1 font-x-small color-grey">
                                            <span class="time-reading"><i class="ti-user"></i>
                                                <a href="{{ route('web.giasu.show', $post->giaSu->user->id) }}">{{ $post->giaSu->user->name ?? 'Không xác định' }}</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--End sidebar-->
        </div>
    </div>
</div>
<div id="reviewModal" class="modal fade" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Đánh giá</h5>
            </div>
            <div class="modal-body">
                <div class="star-rating text-center">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star star" data-rating="{{ $i }}"></i>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .star-rating .star {
        font-size: 30px;
        color: #d6d6d6; /* Sẫm màu */
        cursor: pointer;
        transition: color 0.3s;
    }

    .star-rating .star.hover,
    .star-rating .star.selected {
        color: #ffc107; /* Vàng */
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    $(document).ready(function () {
        let selectedRating = 0;

        // Hover để hiển thị sao sáng
        $(".star-rating .star").on("mouseenter", function () {
            const rating = $(this).data("rating");
            $(".star-rating .star").each(function (index) {
                if (index < rating) {
                    $(this).addClass("hover");
                } else {
                    $(this).removeClass("hover");
                }
            });
        }).on("mouseleave", function () {
            $(".star-rating .star").removeClass("hover");
        });

        // Chọn sao
        $(".star-rating .star").on("click", function () {
            selectedRating = $(this).data("rating");
            $(".star-rating .star").each(function (index) {
                if (index < selectedRating) {
                    $(this).addClass("selected");
                } else {
                    $(this).removeClass("selected");
                }
            });
            
            // Gửi giá trị qua AJAX nếu cần
            $.post('{{ route('web.review.post') }}', { _token: "{{ csrf_token() }}", rating: selectedRating, gia_su_id: {{ $giasu->id }} }, function(res){
                location.reload();
            });
        });
    });
</script>
<script>
    function formatPhoneNumber(phoneNumber) {
        // Loại bỏ tất cả ký tự không phải số
        phoneNumber = phoneNumber.replace(/\D/g, '');

        // Kiểm tra độ dài số điện thoại
        if (phoneNumber.length === 10) {
            return phoneNumber.replace(/(\d{4})(\d{3})(\d{3})/, '$1.$2.$3');
        }

        // Trả về số gốc nếu không hợp lệ
        return phoneNumber;
    }
    $(document).ready(function () {
        $(".show-phone").click(function(e) {
            e.preventDefault();
            var user_id = '{{ $giasu->user->id }}';

            $.ajax({
                url: "{{ route('web.giasu.phone') }}",  // Đảm bảo route này đúng
                method: 'POST',
                data: {
                    user_id,
                    _token: "{{ csrf_token() }}"                
                },
                success: function (response) {
                    if(!isNaN(response)){
                        $(".phone-text1").html(` <i class="fas fa-phone"></i> ${formatPhoneNumber(response)}`);
                        $(".show-phone").hide();
                    }else{
                        Toastify({
                            text: response,
                            duration: 5000, // thời gian hiển thị (ms)
                            close: true, // nút đóng
                            gravity: "bottom", // vị trí: "top" hoặc "bottom"
                            position: "center", // "left", "center", "right"
                        }).showToast();
                    }
                },
                error: function (errr) {
                    console.log(errr)
                }
            });
        });
    });
</script>
@endsection