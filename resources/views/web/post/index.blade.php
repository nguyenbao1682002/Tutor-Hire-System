@extends('Web.layouts.app')
@section('title', 'Tìm Gia Sư')
@section('content')
<!--archive header-->
<div class="archive-header text-center" style="background-image: url({{ asset('assets/imgs/theme/shop-header-bg-2.jpg') }}); padding-top: 25px;">
    <div class="container">
        <h2><span class="color3">
            @if (isset($bySubject))
                {{ $bySubject }}
            @else
                Tìm Gia Sư@if (isset($_GET['area'])): {{ $_GET['area'] }}@endif
            @endif
        </span></h2>
        <div class="breadcrumb">
            <a href="{{ route('web.home.index') }}" rel="nofollow">Trang Chủ </a>
            @if (isset($bySubject))
                <span>{{ $bySubject }}</span>
            @else
                <span>Tìm Gia Sư</span>
            @endif
        </div>
        <div class="bt-1 border-color-1 mt-30 mb-50"></div>
    </div>
</div>
<!--main content-->
<div class="main_content sidebar_right pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <!--loop-list-->
                <div class="loop-grid row">
                    @foreach ($posts as $post)
                        <article class="col-lg-6 mb-50 animate-conner">
                            <div class="post-thumb d-flex mb-30 border-radius-5 img-hover-scale animate-conner-box">
                                <a href="{{ route('web.post.show', $post->slug) }}">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="" style="width: 370px; height: 259px;">
                                </a>
                                <ul class="social-share">
                                    <li><a href="#"><i class="ti-sharethis"></i></a></li>
                                    <li><a class="fb" href="#" title="Share on Facebook" target="_blank"><i class="ti-facebook"></i></a></li>
                                    <li><a class="tw" href="#" target="_blank" title="Tweet now"><i class="ti-twitter-alt"></i></a></li>
                                    <li><a class="pt" href="#" target="_blank" title="Pin it"><i class="ti-pinterest"></i></a></li>
                                </ul>
                            </div>
                            <div class="post-content">
                                <div class="entry-meta meta-0 font-small mb-15">
                                    <a href="{{ route('web.subject.show', $post->subject->slug) }}">
                                        <span
                                            class="post-cat background2 color-white">{{ $post->subject->name ?? 'Chưa có môn học' }}</span>
                                    </a>
                                </div>
                                <h3 class="post-title">
                                    <a href="{{ route('web.post.show', $post->slug) }}">{{ $post->title }}</a>
                                </h3>
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
                        </article>
                    @endforeach
                </div>
                <!--pagination-->
                <div class="pagination-area pt-30 text-center bt-1 border-color-1">
                    {{ $posts->links('pagination::bootstrap-4') }}
                </div>
            </div>
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
                        <div class="post-block-list post-module-1">
                            <ul class="list-post">
                                @foreach ($posts as $key => $post)
                                    @if ($key < 4)
                                        <li class="mb-30">
                                            <div class="d-flex">
                                                <div class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                                    <a href="{{ route('web.post.show', $post->slug) }}">
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
                                    @endif  
                                @endforeach
                            </ul>
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
        </div>
    </div>
</div>
@endsection