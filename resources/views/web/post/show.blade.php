@extends('Web.layouts.app')
@section('title', 'Tìm Gia Sư')
@section('content')
@php
    $phone = $post->giasu->user->phone;
    $formattedPhone = substr($phone, 0, 2) . str_repeat('*', strlen($phone) - 4) . substr($phone, -2);
@endphp
<div class="main_content sidebar_right pb-50 pt-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="entry-header entry-header-1 mb-30">
                    <div class="entry-meta meta-0 font-small mb-15"><a href="{{ route('web.subject.show', $post->subject->slug) }}"><span class="post-cat background2 color-white">{{ $post->subject->name }}</span></a></div>
                    <h1 class="post-title">
                        <a href="#">{{ $post->title }}</a>
                    </h1>
                    <div class="entry-meta meta-1 font-small color-grey mt-15 mb-15">
                        <span class="post-by">Bởi <a href="{{ route('web.giasu.show', $post->giaSu->user->id) }}">{{ $post->giasu->user->name }}</a></span>
                        <span class="post-on has-dot">{{ $post->created_at->format('d M Y') }}</span>
                        <span class="hit-count"><i class="ti-bolt"></i> {{ number_format($post->fee) }} VND</span>
                    </div>
                    <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                    <div class="single-social-share clearfix ">
                        <div class="entry-meta meta-1 font-small color-grey float-left mt-10">
                            <span class="hit-count"><i class="ti-comment mr-5"></i>{{ $comments->count() }} bình luận</span>
                            <span class="hit-count"><i class="ti-bolt"></i>{{ $post->views }} lượt xem</span>
                        </div>
                        <ul class="d-inline-block list-inline float-right">
                            <li class="list-inline-item"><a class="social-icon facebook-icon text-xs-center color-white" target="_blank" href="#"><i class="ti-facebook"></i></a></li>
                            <li class="list-inline-item"><a class="social-icon twitter-icon text-xs-center color-white" target="_blank" href="#"><i class="ti-twitter-alt"></i></a></li>
                            <li class="list-inline-item"><a class="social-icon pinterest-icon text-xs-center color-white" target="_blank" href="#"><i class="ti-pinterest"></i></a></li>
                            <li class="list-inline-item"><a class="social-icon instagram-icon text-xs-center color-white" target="_blank" href="#"><i class="ti-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="entry-main-content">
                    {!! $post->description !!}
                </div>
                <div class="single-social-share clearfix ">
                    <div class="entry-meta meta-1 font-small color-grey float-left mt-10">
                        <span class="hit-count"><i class="ti-comment"></i>{{ $comments->count() }} bình luận</span>
                        <span class="hit-count"><i class="ti-bolt"></i>{{ $post->views }} lượt xem</span>
                    </div>
                    <ul class="d-inline-block list-inline float-right">
                        <li class="list-inline-item"><a class="social-icon facebook-icon text-xs-center color-white" target="_blank" href="#"><i class="ti-facebook"></i></a></li>
                        <li class="list-inline-item"><a class="social-icon twitter-icon text-xs-center color-white" target="_blank" href="#"><i class="ti-twitter-alt"></i></a></li>
                        <li class="list-inline-item"><a class="social-icon pinterest-icon text-xs-center color-white" target="_blank" href="#"><i class="ti-pinterest"></i></a></li>
                        <li class="list-inline-item"><a class="social-icon instagram-icon text-xs-center color-white" target="_blank" href="#"><i class="ti-instagram"></i></a></li>
                    </ul>
                </div>
                <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                <!--author box-->
                <div class="author-bio">
                    <div class="author-image mb-30">
                        <a href="{{ route('web.giasu.show', $post->giaSu->user->id) }}"><img src="{{ empty($post->giaSu->avatar) ? asset('assets/imgs/avatar.png'): asset('storage/'. $post->giaSu->avatar) }}" alt="" class="avatar"></a>
                    </div>
                    <div class="author-info">
                        <h3><span class="vcard author"><span class="fn"><a href="{{ route('web.giasu.show', $post->giaSu->user->id) }}" rel="author">{{ $post->giasu->user->name }}</a></span></span>
                        </h3>
                        <h5>Khu Vực Gia Sư</h5>
                        <div class="author-description"> <i class="ti-location-pin"></i> {{ $post->giasu->area }}</div>
                        <h5>Số Điện Thoại</h5>
                        <div class="author-description phone-text1"> <i class="fas fa-phone"></i> {{ $formattedPhone }} <a href="#" class="author-bio-link show-phone">Xem Đầy Đủ</a></div>
                    </div>
                </div>
                <!--related posts-->
                <div class="related-posts">
                    <h3 class="mb-30">Bài Viết Liên Quan</h3>
                    <div class="loop-list">
                        @foreach ($relatedPosts as $post)
                            <article class="row mb-50">
                                <div class="col-md-6">
                                    <div class="post-thumb position-relative thumb-overlay mr-20">
                                        <div class="img-hover-slide border-radius-5 position-relative"
                                            style="background-image: url('{{ asset('storage/' . $post->image) }}')">
                                            <a class="img-link" href="{{ route('web.post.show', $post->slug) }}"></a>
                                            <span class="top-right-icon background8">
                                                <i class="mdi mdi-flash-on"></i>
                                            </span>
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
                <!--Comments-->
                <div class="comments-area">
                    <h3 class="mb-30 tt-comment">{{ $comments->count() }} Bình Luận</h3>
                    @foreach ($comments as $comment)
                        <div class="comment-list" id="comments-list" >
                            <div class="single-comment justify-content-between d-flex">
                                <div class="user justify-content-between d-flex">
                                    @php
                                        $avatar = null;

                                        if ($comment->user->phuHuynh) {
                                            $avatar = $comment->user->phuHuynh->avatar; // Avatar của phụ huynh
                                        } elseif ($comment->user->giaSu) {
                                            $avatar = $comment->user->giaSu->avatar; // Avatar của gia sư
                                        }
                                    @endphp
                                    <div class="thumb">
                                    <img style="width: 70px; height: 70px;" src="{{ empty($avatar) ? asset('assets/imgs/avatar.png') : asset('storage/' . $avatar) }}" alt="Avatar">
                                    </div>
                                    <div class="desc">
                                        <p class="comment">
                                            {{ $comment->content }}
                                        </p>
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <h5>
                                                    <a href="#">{{ $comment->user->name }}</a>
                                                </h5>
                                            </div>
                                        </div>
                                        <p class="comment mt-3">
                                            {{ $comment->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!--comment form-->
                @if (auth()->user())
                    <div class="comment-form" id="comment-form">
                        <h3 class="mb-30">Bình Luận</h3>
                        <form class="form-contact comment_form" action="#" id="commentForm">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control w-100" name="content" id="content" cols="30" rows="9" placeholder="Viết bình luận"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input value="{{ auth()->user()->name }}" disabled class="form-control" name="name" id="name" type="text" placeholder="Name">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="button button-contactForm">Đăng Bình Luận</button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="comment-form">
                        <h3 class="mb-30">Bình Luận</h3>
                        <form class="form-contact comment_form">
                            <p class="mb-30">Đăng nhập để bình luận về bài viết của gia sư này!</p>
                            <div class="form-group">
                                <a href="{{ route('web.auth.login') }}?post_id={{ $post_id }}" class="button button-contactForm">Đăng Nhập</a>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
            <!--col-lg-8-->
            <!--Right sidebar-->
            <div class="col-lg-4 col-md-12 col-sm-12 primary-sidebar sticky-sidebar">
                <div class="widget-area pl-30">
                    <!--Widget about-->
                    <div class="sidebar-widget widget-about mb-50 pt-30 pr-30 pb-30 pl-30 background12 border-radius-5">
                        <h5 class="mb-20">
                            <a href="{{ route('web.giasu.show', $post->giaSu->user->id) }}">{{ $post->giasu->user->name }}</a>
                        <img class="about-author-img float-right ml-30" src="{{ empty($post->giaSu->avatar) ? asset('assets/imgs/avatar.png'): asset('storage/'. $post->giaSu->avatar) }}" alt=""></h5>
                        <p class="font-medium">{{ $post->giasu->bio }}</p>
                        <h6 class="mb-10">Khu Vực Gia Sư</h6>
                        <p class="font-medium">{{ $post->giasu->area }}</p>
                        <h6 class="mb-10">Số Điện Thoại</h6>
                        <p class="font-medium phone-text">{{ $formattedPhone }}</p>
                        <p>
                            <a class="readmore-btn font-small text-uppercase font-weight-ultra show-phone" href="#">Xem Đầy Đủ<i class="ti-arrow-right ml-5"></i></a>
                        </p>
                    </div>
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
                    <!--Widget categories-->
                    <div class="sidebar-widget widget_categories mb-50">
                        <div class="widget-header position-relative mb-20 pb-10">
                            <h5 class="widget-title mb-10">Môn Học</h5>
                            <div class="bt-1 border-color-1"></div>
                        </div>
                        <div class="post-block-list post-module-1 post-module-5">
                            <ul>
                                @foreach ($subjects as $subject)
                                    <li class="cat-item cat-item-2"><a href="{{ route('web.subject.show', $subject->slug) }}">{{ $subject->name }}</a> ({{ $subject->posts_count }})</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!--Widget latest posts style 2-->
                    <div class="sidebar-widget widget_alitheme_lastpost mb-50">
                        <div class="widget-header position-relative mb-20 pb-10">
                            <h5 class="widget-title mb-10">Được Đề Xuất</h5>
                            <div class="bt-1 border-color-1"></div>
                        </div>
                        <div class="post-block-list">
                            @foreach ($postsRandom as $post)
                                <article class="mb-30">
                                    <div class="post-thumb position-relative thumb-overlay mb-30">
                                        <div class="img-hover-slide border-radius-5 position-relative" style="background-image: url({{ asset('storage/' . $post->image) }})">
                                            <a class="img-link" href="{{ route('web.post.show', $post->slug) }}"></a>
                                        </div>
                                    </div>
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
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--End sidebar-->
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
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
        $('#commentForm').on('submit', function (e) {
            e.preventDefault(); // Ngừng reload trang khi submit form
            var content = $('#content').val();
            if (content === '') {
                alert('Vui lòng nhập bình luận.');
                return;
            }

            var post_id = '{{ $post_id }}'

            $.ajax({
                url: "{{ route('web.comment.post') }}",  // Đảm bảo route này đúng
                method: 'POST',
                data: {
                    content: content,
                    _token: "{{ csrf_token() }}",
                    post_id
                },
                success: function (response) {
                    if ($('#comments-list').length === 0) {
                        $('.comments-area').append('<div class="comment-list" id="comments-list"></div>'); // Hoặc thêm vào vị trí khác trong DOM
                    }

                    // Xử lý nếu gửi thành công
                    if (response.success) {
                        // Tạo HTML cho bình luận mới
                        var newCommentHtml = `
                            <div class="comment-list" id="comment-${response.comment.id}">
                                <div class="single-comment justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img style="width: 70px; height: 70px;" src="${response.comment.avatar}" alt="Avatar">
                                        </div>
                                        <div class="desc">
                                            <p class="comment">${response.comment.content}</p>
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <h5><a href="#">${response.comment.user_name}</a></h5>
                                                </div>
                                            </div>
                                            <p class="comment mt-3">${response.comment.created_at}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        // Thêm bình luận mới vào đầu danh sách
                        $('#comments-list').prepend(newCommentHtml);

                        // Lấy giá trị hiện tại của thẻ <h3> có class tt-comment
                        var commentCount = parseInt($('.tt-comment').text()); // Lấy số bình luận hiện tại, loại bỏ phần "Bình Luận"

                        // Cộng thêm 1
                        commentCount += 1;

                        // Cập nhật lại số bình luận trong thẻ <h3>
                        $('.tt-comment').text(commentCount + ' Bình Luận');

                        $('html, body').animate({
                            scrollTop: $('#comments-list').offset().top - 200
                        }, 500); // 500ms độ trễ cuộn

                        // Reset form
                        $('#content').val('');
                    }
                },
                error: function (errr) {
                    console.log(errr)
                    alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
        });

        $(".show-phone").click(function(e) {
            e.preventDefault();
            var user_id = '{{ $user_id }}';
            var post_id = '{{ $post_id }}';

            $.ajax({
                url: "{{ route('web.giasu.phone') }}",  // Đảm bảo route này đúng
                method: 'POST',
                data: {
                    user_id,
                    _token: "{{ csrf_token() }}",
                    post_id
                },
                success: function (response) {
                    if(!isNaN(response)){
                        $(".phone-text1").html(` <i class="fas fa-phone"></i> ${formatPhoneNumber(response)}`);
                        $(".phone-text").html(formatPhoneNumber(response));
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
                    alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
        });
    });
</script>
@endsection