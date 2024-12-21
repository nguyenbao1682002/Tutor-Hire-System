<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Post;

class WebHomeController extends Controller
{
    public function index(){
        // Lấy danh sách Subject cùng số lượng bài viết
        $subjects = Subject::withCount(['posts' => function ($query) {
            $query->where('status', 'accept');
        }])->get();

        $posts = Post::with(['giaSu.user', 'subject'])
        ->where('status', 'accept')
        ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian tạo
        ->paginate(10); // Mỗi trang hiển thị 10 bài

        $topPosts = Post::with(['giaSu.user', 'subject']) // Load các mối quan hệ cần thiết
        ->where('status', 'accept') // Điều kiện: chỉ lấy bài viết được duyệt
        ->orderBy('views', 'desc')  // Sắp xếp theo lượt xem giảm dần
        ->take(10)                  // Lấy 10 bài viết đầu tiên
        ->get();

        return view('web.home.index', compact('subjects', 'posts', 'topPosts'));
    }
}
