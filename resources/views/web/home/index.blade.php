@extends('Web.layouts.app')
@section('title', 'Trang Chủ')
@section('content')
<div class="recent-area pt-50 pb-50 background12">
    <div class="container">
        <!--Editor's Picked Start-->
        <div class="widgets-post-carausel-1 mb-60">
            <div class="post-carausel-1 border-radius-10 bg-white">
                <div class="row no-gutters">
                    <div class="col col-1-5 background6 editor-picked-left d-none d-lg-block">
                        <div class="editor-picked">
                            <h4>Theo Môn Học</h4>
                            <p class="font-medium color-grey mt-20 mb-30">Lựa chọn môn học cần tìm kiếm gia sư, chúng
                                tôi sẽ chọn lọc và cung cấp cho phụ huynh các thông tin mới nhất!</p>
                            <div class="post-carausel-1-arrow"></div>
                        </div>
                    </div>
                    <div class="col col-4-5 col-md-12">
                        <div class="post-carausel-1-items row">
                            @foreach ($subjects as $subject)
                                <div class="slider-single col">
                                    <!-- Hiển thị tên Subject -->
                                    <h6 class="post-title pr-5 pl-5 mb-10 text-limit-2-row">
                                        <a href="{{ route('web.subject.show', $subject->slug) }}">{{ $subject->name }}</a>
                                    </h6>
                                    <!-- Hiển thị hình ảnh Subject -->
                                    <div class="img-hover-scale border-radius-5 hover-box-shadow">
                                        <a href="{{ route('web.subject.show', $subject->slug) }}">
                                            <img style="height: 197px; width: 100%;" class="border-radius-5"
                                                src="{{ asset('storage/' . $subject->image) ?? 'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png' }}"
                                                alt="subject-image">
                                        </a>
                                    </div>
                                    <!-- Hiển thị số lượng bài viết -->
                                    <div class="entry-meta meta-1 font-small color-grey mt-10 pr-5 pl-5">
                                        <span class="post-on">{{ $subject->posts_count }} bài viết</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Editor's Picked End-->
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="widget-header position-relative mb-30">
                    <h5 class="widget-title mb-30 text-uppercase color1 font-weight-ultra">Bài Đăng Mới</h5>
                    <div class="letter-background">Latest</div>
                </div>
                <div class="loop-list">
                    @foreach ($posts as $post)
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
                <!-- Hiển thị phân trang -->
                <div class="pagination-area pt-30 text-center bt-1 border-color-1">
                    {{ $posts->links('pagination::bootstrap-4') }}
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="widget-area">
                    <!-- Social Network -->
                    <div class="sidebar-widget widget-social-network mb-30">
                        <div class="widget-header position-relative mb-30">
                            <h5 class="widget-title mt-5 mb-30">Theo Dõi</h5>
                        </div>
                        <div class="social-network">
                            <div class="follow-us d-flex align-items-center">
                                <a class="follow-us-facebook clearfix mr-5 mb-10" href="https://www.facebook.com/profile.php?id=61570864078590" target="_blank">
                                    <div class="social-icon">
                                        <i class="ti-facebook mr-5 v-align-space"></i>
                                        <i class="ti-facebook mr-5 v-align-space nth-2"></i>
                                    </div>
                                    <span class="social-name">Facebook</span>
                                    <span class="social-count counter-number">65</span><span
                                        class="social-count">K</span>
                                </a>
                                <a class="follow-us-twitter clearfix ml-5 mb-10" href="#" target="_blank">
                                    <div class="social-icon">
                                        <i class="ti-twitter-alt mr-5 v-align-space"></i>
                                        <i class="ti-twitter-alt mr-5 v-align-space nth-2"></i>
                                    </div>
                                    <span class="social-name">Twitter</span>
                                    <span class="social-count counter-number">75</span><span
                                        class="social-count">K</span>
                                </a>
                            </div>
                            <div class="follow-us d-flex align-items-center">
                                <a class="follow-us-instagram clearfix mr-5" href="#" target="_blank">
                                    <div class="social-icon">
                                        <i class="ti-instagram mr-5 v-align-space"></i>
                                        <i class="ti-instagram mr-5 v-align-space nth-2"></i>
                                    </div>
                                    <span class="social-name">Maps</span>
                                    <span class="social-count counter-number">32</span><span
                                        class="social-count">K</span>
                                </a>
                                <a class="follow-us-youtube clearfix ml-5" href="https://www.youtube.com/@tutoruvn" target="_blank">
                                    <div class="social-icon">
                                        <i class="ti-youtube mr-5 v-align-space"></i>
                                        <i class="ti-youtube mr-5 v-align-space nth-2"></i>
                                    </div>
                                    <span class="social-name">Youtube</span>
                                    <span class="social-count counter-number">28</span><span
                                        class="social-count">K</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--taber-->
                    <div class="sidebar-widget widget-taber mb-30">
                        <div class="widget-taber-content background-white pt-30 pb-30 pl-30 pr-30 border-radius-5">
                            <nav class="tab-nav float-none mb-20">
                                <div class="nav nav-tabs" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-popular-tab" data-toggle="tab"
                                        href="#nav-popular" role="tab" aria-controls="nav-popular"
                                        aria-selected="true">Nổi Bật</a>
                                    <a class="nav-item nav-link" id="nav-trending-tab" data-toggle="tab"
                                        href="#nav-trending" role="tab" aria-controls="nav-trending"
                                        aria-selected="false">Đề Xuất</a>
                                    <a class="nav-item nav-link" id="nav-comment-tab" data-toggle="tab"
                                        href="#nav-comment" role="tab" aria-controls="nav-comment"
                                        aria-selected="false">Cộng Đồng</a>
                                </div>
                            </nav>
                            <div class="tab-content">
                                <!--Tab Popular-->
                                <div class="tab-pane fade show active" id="nav-popular" role="tabpanel"
                                    aria-labelledby="nav-popular-tab">
                                    <div class="post-block-list post-module-1">
                                        <ul class="list-post">
                                            @foreach ($topPosts as $post)
                                                <li class="mb-30">
                                                    <div class="d-flex">
                                                        <div
                                                            class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                                            <a href="{{ route('web.post.show', $post->slug) }}">
                                                                <img src="{{ asset('storage/' . $post->image) }}" style="width: 130px; height: 130px;" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="post-content media-body">
                                                            <div class="entry-meta meta-0 mb-10">
                                                                <a href="{{ route('web.subject.show', $post->subject->slug) }}">
                                                                    <span
                                                                        class="post-cat background2 color-white">{{ $post->subject->name ?? 'Chưa có môn học' }}</span>
                                                                </a>
                                                            </div>
                                                            <h6 class="post-title mb-10 text-limit-2-row">{{ $post->title }}</h6>
                                                            <div class="entry-meta meta-1 font-x-small color-grey">
                                                                <span class="post-on">{{ $post->created_at->format('d M Y') }}</span>
                                                                <span class="hit-count has-dot">{{ $post->views }} lượt xem</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <!--Tab Trending-->
                                <div class="tab-pane fade" id="nav-trending" role="tabpanel"
                                    aria-labelledby="nav-trending-tab">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 sm-grid-content mb-30">
                                            <div class="post-thumb d-flex border-radius-5 img-hover-scale mb-15">
                                                <a href="https://vnexpress.net/lo-luyen-thi-vao-harvard-4804946.html">
                                                    <img src="https://i1-giadinh.vnecdn.net/2024/10/17/775115567849d71f30f3fcd901a596-7711-4100-1729133712.png?w=500&h=300&q=100&dpr=1&fit=crop&s=cU7Ov7OSPQDY6ikTXdy1Fg" alt="">
                                                </a>
                                            </div>
                                            <div class="post-content media-body">
                                                <h6 class="post-title mb-10 text-limit-2-row">Lò luyện thi vào Harvard </h6>
                                                <div class="entry-meta meta-1 font-x-small color-grey">
                                                    <span class="post-on">Thứ Ba, 17/12/2024</span>
                                                    <span class="hit-count has-dot">101k Views</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 sm-grid-content mb-30">
                                            <div class="post-thumb d-flex border-radius-5 img-hover-scale mb-15">
                                                <a href="https://vnexpress.net/nghe-sieu-gia-su-o-trung-quoc-4754877.html">
                                                    <img src="https://i1-giadinh.vnecdn.net/2024/06/06/hotro22-1717642902-3311-1717644884.jpg?w=500&h=300&q=100&dpr=1&fit=crop&s=FklZ9o7pj_EefVSi7ZdpZA" alt="">
                                                </a>
                                            </div>
                                            <div class="post-content media-body">
                                                <h6 class="post-title mb-10 text-limit-2-row">Nghề 'siêu gia sư' ở Trung Quốc</h6>
                                                <div class="entry-meta meta-1 font-x-small color-grey mt-10">
                                                    <span class="post-on">Thứ Hai, 16/12/2024</span>
                                                    <span class="hit-count has-dot">126k Views</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 sm-grid-content mb-30">
                                            <div class="post-thumb d-flex border-radius-5 img-hover-scale mb-15">
                                                <a href="https://vnexpress.net/gia-su-co-quyen-khong-cho-phu-huynh-dang-video-day-hoc-4639277.html">
                                                    <img src="https://i1-vnexpress.vnecdn.net/2023/08/08/huongdanhocthiieltschong390935-8784-5706-1691478161.jpg?w=500&h=300&q=100&dpr=1&fit=crop&s=zJ3ZRbfLfYkJbmo3OR6KLw" alt="">
                                                </a>
                                            </div>
                                            <div class="post-content media-body">
                                                <h6 class="post-title mb-10 text-limit-2-row">Gia sư có quyền không cho phụ huynh đăng video dạy học?</h6>
                                                <div class="entry-meta meta-1 font-x-small color-grey">
                                                    <span class="post-on">Chủ Nhật, 15/12/2024</span>
                                                    <span class="hit-count has-dot">141k Views</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 sm-grid-content mb-30">
                                            <div class="post-thumb d-flex border-radius-5 img-hover-scale mb-15">
                                                <a href="https://vnexpress.net/thue-gia-su-vi-con-khong-the-doc-viet-sau-hoc-on-off-4437075.html">
                                                    <img src="https://i1-vnexpress.vnecdn.net/2022/03/10/111vieclamonlineparttimechosin-1236-3456-1646896659.jpg?w=320&h=320&q=100&dpr=1&fit=crop&s=5C91doRjJgx3W1bWTSy2ig" alt="">
                                                </a>
                                            </div>
                                            <div class="post-content media-body">
                                                <h6 class="post-title mb-10 text-limit-2-row">Thuê gia sư vì con không thể đọc, viết sau học on - off</h6>
                                                <div class="entry-meta meta-1 font-x-small color-grey mt-10">
                                                    <span class="post-on">Thứ Bảy, 14/12/2024</span>
                                                    <span class="hit-count has-dot">186k Views</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 sm-grid-content">
                                            <div class="post-thumb d-flex border-radius-5 img-hover-scale mb-15">
                                                <a href="https://vnexpress.net/gia-su-nga-nghieng-khi-day-kem-hoc-tro-4140430.html">
                                                    <img src="https://i1-vnexpress.vnecdn.net/2020/08/03/Screenshot-287-8883-1596427562.png?w=680&h=0&q=100&dpr=1&fit=crop&s=nxiQnZjurlPkQHJt4ogN3A" alt="">
                                                </a>
                                            </div>
                                            <div class="post-content media-body">
                                                <h6 class="post-title mb-10 text-limit-2-row">'Gia sư' ngả nghiêng khi dạy kèm học trò</h6>
                                                <div class="entry-meta meta-1 font-x-small color-grey mt-10">
                                                    <span class="post-on">Thứ Sáu, 13/12/2024</span>
                                                    <span class="hit-count has-dot">211k Views</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 sm-grid-content">
                                            <div class="post-thumb d-flex border-radius-5 img-hover-scale mb-15">
                                                <a href="https://vnexpress.net/nam-dau-hieu-cho-thay-con-ban-can-gia-su-3831112.html">
                                                    <img src="https://i1-vnexpress.vnecdn.net/2018/10/29/gia-su-1540805341-1540805359-7940-1540805507.jpg?w=500&h=300&q=100&dpr=1&fit=crop&s=dyk1H9Iddj3HIeA41_I8jw" alt="">
                                                </a>
                                            </div>
                                            <div class="post-content media-body">
                                                <h6 class="post-title mb-10 text-limit-2-row">MNăm dấu hiệu cho thấy con bạn cần gia sư</h6>
                                                <div class="entry-meta meta-1 font-x-small color-grey mt-10">
                                                    <span class="post-on">Thứ Năm, 12/12/2024</span>
                                                    <span class="hit-count has-dot">250k Views</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab Comments-->
                                <div class="tab-pane fade" id="nav-comment" role="tabpanel"
                                    aria-labelledby="nav-comment-tab">
                                    <div class="post-block-list post-module-1">
                                        <ul class="list-post">
                                            <li class="mb-30">
                                                <div class="d-flex">
                                                    <div
                                                        class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                                        <a href="https://www.facebook.com/groups/congdonggiasusinhvien/">
                                                            <img src="https://scontent.fdad1-4.fna.fbcdn.net/v/t39.30808-6/361606626_3321961398053274_7097267025739111455_n.jpg?stp=dst-jpg_s960x960_tt6&_nc_cat=103&ccb=1-7&_nc_sid=2285d6&_nc_eui2=AeGx9XwXKqrEZS3RH8_8RdHjOFGLdFK0em04UYt0UrR6bZtXHnSgb7U3eg8jo_U6JywWStJlaHLbBqD8MqiQF5kx&_nc_ohc=oueYzyjsvHgQ7kNvgEHzRxY&_nc_oc=AdhDzg9QVMDHho4y8vh-mkHp9C91KQrsJZQQM37a6fygGNc3YEiSxRFZsA8dgQAmlRXYEhmvvEposmf-c6rGJ32e&_nc_zt=23&_nc_ht=scontent.fdad1-4.fna&_nc_gid=AyWwBm64zo6pJhCPAPQlRK0&oh=00_AYDMluWHqLFlCH3-WVe98p6LaqMJVTAGsq6mFkpwjwn0OQ&oe=67682D3A" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-content media-body">
                                                        <div class="entry-meta meta-0 mb-10">
                                                            <a href="category.html"><span
                                                                    class="post-in background2 color-white font-small">Sinh Viên</span></a>
                                                        </div>
                                                        <h6 class="post-title mb-10 text-limit-2-row">Cộng Đồng Gia Sư Sinh Viên</h6>
                                                        <div class="entry-meta meta-1 font-x-small color-grey">
                                                            <span class="post-on">Nhóm Công Khai</span>
                                                            <span class="hit-count has-dot">44,5K Thành Viên</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-30">
                                                <div class="d-flex">
                                                    <div
                                                        class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                                        <a href="https://www.facebook.com/groups/1220600238373282">
                                                            <img src="https://scontent.fdad2-1.fna.fbcdn.net/v/t1.6435-9/176334739_4595558130460044_3053950945899243401_n.jpg?stp=dst-jpg_s960x960_tt6&_nc_cat=107&ccb=1-7&_nc_sid=2285d6&_nc_eui2=AeHtrPlM74ivD5dPlfSn29RB3dY5L7enDsXd1jkvt6cOxUrU0k_-1JOSbOY_l-kLpdqwC9baDws6ImjovVkfN8NA&_nc_ohc=taHQnNva-hsQ7kNvgGFIPnW&_nc_oc=AdheYkZSN0962htOKjIiKwTchj9Tjpr7-n6F8AY1I-3mpuH6jIbh5AtXGS5FoDBUJhKktNoYXPkGooY4K7NhA2aO&_nc_zt=23&_nc_ht=scontent.fdad2-1.fna&_nc_gid=AdAnmKoAmXjEo_Xm3xZGMdZ&oh=00_AYA8Na-GWa2FJ3SH3ABQ_BzXmuqYR50hZvSIsa1VqBaQHg&oe=6789BEDB" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-content media-body">
                                                        <div class="entry-meta meta-0 mb-10">
                                                            <a href="category.html"><span
                                                                    class="post-in background3 color-white font-small">Đà Nẵng</span></a>
                                                        </div>
                                                        <h6 class="post-title mb-10 text-limit-2-row">Gia sư Đà Nẵng - Dạy kèm tại nhà Đà Nẵng</h6>
                                                        <div class="entry-meta meta-1 font-x-small color-grey mt-10">
                                                            <span class="post-on">Nhóm Công Khai</span>
                                                            <span class="hit-count has-dot">20,5K Thành Viên</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-30">
                                                <div class="d-flex">
                                                    <div
                                                        class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                                        <a href="https://www.facebook.com/groups/322860914950227">
                                                            <img src="https://scontent.fdad1-3.fna.fbcdn.net/v/t39.30808-6/299900214_622621759207903_2898320643734712436_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=2285d6&_nc_eui2=AeF21u8rlQT6eSMvrHPPRKnllKO9L23EseiUo70vbcSx6G5CoX3B-CwRsqT7fSAmdB0vrbZuU6ic-jTfhXTl_GLd&_nc_ohc=C6aqGTjRINIQ7kNvgEB9yYS&_nc_oc=Adh1Y1aJoceLGra580hnx5q72iXeWknEIMNNeW8a0qtJcGd2lWzBAeRnGz83fM9WpPcpn2c_RuCZem_fKFEMhtoy&_nc_zt=23&_nc_ht=scontent.fdad1-3.fna&_nc_gid=AykoPjVp-g4FECXO4pCN_mv&oh=00_AYCWe36UFHInDjrdsRFRuZoZKTpzt_ICn9XXATYplTcZbw&oe=6768222C" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-content media-body">
                                                        <div class="entry-meta meta-0 mb-10">
                                                            <a href="category.html"><span
                                                                    class="post-in background7 color-white font-small">Hà Nội</span></a>
                                                        </div>
                                                        <h6 class="post-title mb-10 text-limit-2-row">Cộng đồng gia sư Hà Nội</h6>
                                                        <div class="entry-meta meta-1 font-x-small color-grey mt-10">
                                                            <span class="post-on">Nhóm Công Khai</span>
                                                            <span class="hit-count has-dot">109,4K Thành Viên</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex">
                                                    <div
                                                        class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                                        <a href="https://www.facebook.com/groups/giasudaykemtainhatphcm">
                                                            <img src="https://scontent.fdad2-1.fna.fbcdn.net/v/t39.30808-6/333935420_491844979635774_5403552397005721998_n.png?stp=dst-jpg_s960x960_tt6&_nc_cat=107&ccb=1-7&_nc_sid=2285d6&_nc_eui2=AeHrpujQTLPXXEvHwQ-1Ee9fH1y0nBXOZNsfXLScFc5k28DzB_p6z0uzorTU_gDU96ekuAFomCliDUWD6v4Ju8Ha&_nc_ohc=W1uo02qGdgwQ7kNvgFrtpI_&_nc_oc=AdijksO3k6ZzBVMEKP4i1YgPdmoB7mJG-co8WsjdB7T7DruGWq3ZiX3NkyRr0tMv5NfQFjrfD3hAHaYfOXAmjzLq&_nc_zt=23&_nc_ht=scontent.fdad2-1.fna&_nc_gid=AtiO1ZhjSlJWkveEpMlIPDu&oh=00_AYDdf7ZS2WHLCaVmXSCJieKOYMovF2q6degKbibnHq556g&oe=67682FC5" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-content media-body">
                                                        <div class="entry-meta meta-0 mb-10">
                                                            <a href="category.html"><span
                                                                    class="post-in background8 color-white font-small">Hồ Chí Minh</span></a>
                                                        </div>
                                                        <h6 class="post-title mb-10 text-limit-2-row">CỘNG ĐỒNG GIA SƯ DẠY KÈM TẠI NHÀ TPHCM</h6>
                                                        <div class="entry-meta meta-1 font-x-small color-grey mt-10">
                                                            <span class="post-on">Nhóm Công Khai</span>
                                                            <span class="hit-count has-dot">261,5K Thành Viên</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Ads -->
                    <div class="sidebar-widget widget-ads mb-30 text-center">
                        <a href="https://www.youtube.com/watch?v=GGV229IpwzM" class="play-video" data-animate="zoomIn"
                            data-duration="1.5s" data-delay="0.1s">
                            <img class="d-inline-block" src="assets/imgs/gia_su_homepage.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection