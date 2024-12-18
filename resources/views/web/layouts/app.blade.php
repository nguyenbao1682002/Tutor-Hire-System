<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/imgs/favicon.png') }}">
    <!-- UltraNews CSS  -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/widgets.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
    <div class="scroll-progress primary-bg"></div>
    <div class="main-wrap">
        <!--Offcanvas sidebar-->
        <aside id="sidebar-wrapper" class="custom-scrollbar offcanvas-sidebar position-right">
            <button class="off-canvas-close"><i class="ti-close"></i></button>
            <div class="sidebar-inner">
                <!--Categories-->
                <div class="sidebar-widget widget_categories mb-50">
                    <div class="widget-header position-relative mb-20">
                        <h5 class="widget-title mt-5">Môn Học</h5>
                    </div>
                    <div class="post-block-list post-module-1 post-module-5">
                        @php
                            $monhoclist = \App\Models\Subject::withCount(['posts' => function ($query) {
                                $query->where('status', 'accept');
                            }])->get();
                        @endphp
                        <ul>
                            @foreach ($monhoclist as $subject)
                                <li class="cat-item cat-item-2"><a href="{{ route('web.subject.show', $subject->slug) }}">{{ $subject->name }}</a> ({{ $subject->posts_count }})</li>
                            @endforeach             
                        </ul>
                    </div>
                </div>
                <div class="sidebar-widget widget-latest-posts mb-30">
                    <div class="widget-header position-relative mb-30">
                        <h5 class="widget-title mt-5 mb-30">Được Đề Xuất</h5>
                    </div>
                    <div class="post-block-list post-module-1 post-module-5">
                        @php
                            $postRandomList = \App\Models\Post::with(['giaSu.user', 'subject'])
                            ->where('status', 'accept')
                            ->inRandomOrder() // Lấy ngẫu nhiên
                            ->limit(5) // Giới hạn 2 bài
                            ->get(); // Lấy danh sách bài viết
                        @endphp
                        <ul class="list-post">
                            @foreach ($postRandomList as $post)
                                <li class="mb-30">
                                    <div class="d-flex">
                                        <div class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                            <a href="single.html">
                                                <img src="{{ asset('storage/' . $post->image) }}" alt="" style="width: 130px; height: 130px;">
                                            </a>
                                        </div>
                                        <div class="post-content media-body">
                                            <div class="entry-meta meta-0 mb-10">
                                                <a href="{{ route('web.subject.show', $post->subject->slug) }}"><span class="post-in background4 color-white font-small">{{ $post->subject->name ?? 'Chưa có môn học' }}</span></a>
                                            </div>
                                            <h6 class="post-title mb-10 text-limit-2-row"><a href="{{ route('web.post.show', $post->slug) }}">{{ $post->title }}</a></h6>
                                            <div class="entry-meta meta-1 font-x-small color-grey">
                                                <span class="post-on"><a href="{{ route('web.giasu.show', $post->giaSu->user->id) }}">{{ $post->giaSu->user->name ?? 'Không xác định' }}</a></span>
                                                <span class="hit-count has-dot">{{ $post->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- Main Wrap Start -->
        <header class="main-header header-style-2 header-style-3">
            <div class="top-bar background4 d-none d-md-block color-white">
                <div class="container">
                    <div class="topbar-inner pt-10 pb-10">
                        <div class="row">
                            <div class="col-6 text-left">
                                <ul class="header-social-network d-inline-block list-inline color-white">
                                    <li class="list-inline-item"><a class="text-white" href="{{ route('web.home.index') }}">TRANG CHỦ</a></li>
                                    <div class="vline-space d-inline-block"></div>
                                    <li class="list-inline-item"><a class="text-white" href="">GIỚI THIỆU</a></li>
                                    <div class="vline-space d-inline-block"></div>
                                    <li class="list-inline-item"><a class="text-white" href="">LIÊN HỆ</a></li>
                                </ul>
                            </div>
                            <div class="col-6 text-right">
                                <ul class="header-social-network d-inline-block list-inline color-white">
                                    <li class="list-inline-item"><a class="social-icon facebook-icon text-xs-center color-white" target="_blank" href="https://www.facebook.com/profile.php?id=61570864078590"><i class="ti-facebook"></i></a></li>
                                    <li class="list-inline-item"><a class="social-icon twitter-icon text-xs-center color-white" target="_blank" href="https://www.youtube.com/@tutoruvn"><i class="ti-youtube"></i></a></li>
                                    <li class="list-inline-item"><a class="social-icon pinterest-icon text-xs-center color-white" target="_blank" href="https://www.google.com/maps/place/%C4%90%E1%BA%A1i+H%E1%BB%8Dc+Duy+T%C3%A2n+H%C3%B2a+Kh%C3%A1nh+Nam/@16.0492967,108.1575217,17z/data=!3m1!4b1!4m6!3m5!1s0x31421938d61a3ce5:0x29d80f3ebbdcb44a!8m2!3d16.0492916!4d108.1600966!16s%2Fg%2F11f15kljlk?hl=vi-VN&entry=ttu&g_ep=EgoyMDI0MTIxMS4wIKXMDSoASAFQAw%3D%3D"><i class="ti-location-arrow"></i></a></li>
                                    <li class="list-inline-item"><a class="social-icon instagram-icon text-xs-center color-white" target="_blank" href="#"><i class="ti-instagram"></i></a></li>
                                </ul>
                                <div class="vline-space d-inline-block"></div>
                                @if (Auth::check())
                                    <div class="user-account d-inline-block font-small">
                                        <a class="dropdown-toggle color-white" href="#" role="button" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-user"></i>
                                            <span>{{ Auth::user()->name }}</span>
                                        </a>
                                        @if (Auth::user()->role == "phu_huynh")
                                            <div id="userMenuDropdow" class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
                                                @php
                                                    $phuHuynhCommon = \App\Models\PhuHuynh::where('user_id', auth()->user()->id)->first();
                                                @endphp
                                                <a class="dropdown-item text-center" href="#">
                                                    {{ number_format($phuHuynhCommon->balance) }} VNĐ
                                                </a>
                                                <a class="dropdown-item" href="{{ route('web.phuhuynh.show') }}">
                                                    <i class="fa fa-user"></i> Cá Nhân
                                                </a>
                                                <a class="dropdown-item" href="{{ route('web.phuhuynh.pay') }}">
                                                    <i class="fa fa-dollar-sign"></i> Nạp Tiền
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{ route('web.auth.logout') }}"><i class="fa fa-sign-out-alt"></i> Đăng Xuất</a>
                                            </div>
                                        @else
                                            <div id="userMenuDropdow" class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
                                                <a class="dropdown-item" href="{{ route('web.giasu.show', Auth::user()->id) }}"><i class="fa fa-user"></i> Trang Cá Nhân</a>
                                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fa fa-chart-line"></i> Trang Quản Lý</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{ route('web.auth.logout') }}"><i class="fa fa-sign-out-alt"></i> Đăng Xuất</a>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="user-account d-inline-block font-small">
                                        <a class="color-white" href="{{ route('web.auth.login') }}" id="userMenu">
                                            <i class="fa fa-user"></i>
                                            <span>Đăng Nhập</span>
                                        </a>
                                    </div>
                                    <div class="vline-space d-inline-block"></div>
                                    <div class="user-account d-inline-block font-small">
                                        <a class="dropdown-toggle color-white" href="#" role="button" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-user-plus"></i>
                                            <span>Đăng Ký</span>
                                        </a>
                                        <div id="userMenuDropdow" class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
                                            <a class="dropdown-item" href="{{ route('web.auth.tutorRegister') }}"><i class="fa fa-user"></i> Làm Gia Sư</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('web.auth.parentRegister') }}"><i class="fa fa-users"></i> Làm Phụ Huynh</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End top bar-->
            <!--End top bar-->
            <div class="header-logo background-white pt-20 pb-20 d-none d-lg-block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-12 align-center-vertical">
                            <a href="{{ route('web.home.index') }}">
                                <img class="logo-img d-inline" src="{{ asset('assets/imgs/logo-tablet.png') }}" alt="">
                            </a>
                        </div>
                        <div class="col-lg-8 col-md-12 align-center-vertical d-none d-lg-inline text-right">
                            <a href="{{ route('web.home.index') }}">
                                <img class="ads-img d-inline" src="assets/imgs/logo-mobi.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--End logo-->
            <div class="header-bottom header-sticky background-white text-center">
                <div class="mobile_menu d-lg-none d-block"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="off-canvas-toggle-cover">
                                <div class="off-canvas-toggle hidden d-inline-block ml-15" id="off-canvas-toggle">
                                    <span></span>
                                    <p class="font-small d-none d-md-inline">LỰA CHỌN</p>
                                </div>
                            </div>
                            <div class="logo-tablet d-md-inline d-lg-none d-none">
                                <a href="{{ route('web.home.index') }}">
                                    <img class="logo-img d-inline" src="assets/imgs/logo-tablet.png" alt="">
                                </a>
                            </div>
                            <div class="logo-mobile d-inline d-md-none">
                                <a href="{{ route('web.home.index') }}">
                                    <img class="logo-img d-inline" src="assets/imgs/logo-mobi.png" alt="">
                                </a>
                            </div>
                            <!-- Main-menu -->
                            <div class="main-nav text-left d-none d-lg-block">
                                <nav>
                                    <ul id="navigation" class="main-menu">
                                        <li>
                                            <a href="{{ route('web.home.index') }}">Trang Chủ</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('web.giasu.index') }}">Bài Đăng Gia Sư</a>
                                        </li>
                                        <li class="menu-item-has-children">
                                            <a href="#">Khu Vực Gia Sư</a>
                                            <ul class="sub-menu">
                                                <li>
                                                    <a href="{{ route('web.giasu.index') }}?area=Thành phố Hà Nội">Khu Vực Hà Nội</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('web.giasu.index') }}?area=Thành phố Hồ Chí Minh">Khu Vực Hồ Chí Minh</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('web.giasu.index') }}?area=Thành phố Đà Nẵng">Khu Vực Đà Nẵng</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('web.giasu.index') }}?area=Thành phố Cần Thơ">Khu Vực Cần Thơ</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('web.giasu.index') }}?area=Thành phố Hải Phòng">Khu Vực Hải Phòng</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu-item-has-children">
                                            <a href="#">Môn Học Gia Sư</a>
                                            <ul class="sub-menu">
                                                @foreach ($monhoclist as $subject)
                                                    <li>
                                                        <a href="{{ route('web.subject.show', $subject->slug) }}">{{ $subject->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="{{ route('web.vip.show') }}">Mua Gói VIP</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- Search -->
                            <div class="search-button">
                                <button class="search-icon"><i class="ti-search"></i></button>
                                <span class="search-close float-right font-small"><i class="ti-close mr-5"></i>CLOSE</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main class="position-relative">
            <!--Search Form-->
            <div class="main-search-form transition-02s">
                <div class="container">
                    <div class="pt-50 pb-50 main-search-form-cover">
                        <div class="row mb-20">
                            <div class="col-12">
                                <form action="{{ route('web.giasu.index') }}" method="get" class="search-form position-relative">
                                    <div class="search-form-icon"><i class="ti-search"></i></div>
                                    <label>
                                        <input type="text" class="search_field" placeholder="Tìm kiếm" value="{{ request('s') }}" name="s">
                                    </label>
                                    <div class="search-switch">
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><a href="#" class="active">Môn Học</a></li>
                                            <li class="list-inline-item"><a href="#">Tác Giả</a></li>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 font-small suggested-area">
                                <p class="d-inline font-small suggested"><strong>Đề Xuất:</strong></p>
                                <ul class="list-inline d-inline-block">
                                    <li class="list-inline-item"><a href="#">Môn Toán</a></li>
                                    <li class="list-inline-item"><a href="#">Tiếng Việt</a></li>
                                    <li class="list-inline-item"><a href="#">Tiếng Anh Lớp 3</a></li>
                                    <li class="list-inline-item"><a href="#">Đại Số</a></li>
                                    <li class="list-inline-item"><a href="#">Hình Học Lớp 5</a></li>
                                    <li class="list-inline-item"><a href="#">Ôn Thi</a></li>
                                    <li class="list-inline-item"><a href="#">Ngữ Văn</a></li>
                                    <li class="list-inline-item"><a href="#">Luyện Thi</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @yield('content')
           
        </main>
        <footer>
            <!-- footer-bottom aera -->
            <div class="footer-bottom-area background11">
                <div class="container">
                    <div class="footer-border pt-30 pb-30">
                        <div class="row d-flex align-items-center justify-content-between">
                            <div class="col-lg-6">
                                <div class="footer-copy-right">
                                    <p class="font-medium">© 2024 - 2025, Tutor Hire System | Toàn bộ nội dung | Thiết kế bởi <a href="{{ route('web.home.index') }}" target="_blank">C2SE.01</a></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="footer-menu float-lg-right mt-lg-0 mt-3">
                                    <ul class="font-medium">
                                        <li><a href="{{ route('web.home.index') }}">Trang Chủ</a></li>
                                        <li><a href="#">Giới Thiệu</a></li>
                                        <li><a href="#">Liên Hệ</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End-->
        </footer>
    </div>
    <!-- Main Wrap End-->
    <div class="dark-mark"></div>
    <!-- Vendor JS-->
    <script src="{{ asset('assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/animated.headline.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.ticker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.sticky.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.theia.sticky.js') }}"></script>
    <!-- UltraNews JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
@yield('script')