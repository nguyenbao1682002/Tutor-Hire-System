<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Subject;
use App\Models\Comment;
use Illuminate\Support\Facades\Session;

class WebPostController extends Controller
{
    public function index()
    {
        // Lấy tham số tìm kiếm từ URL (nếu có)
        $search = request('s'); // Tương đương $_GET['s']

        // Lấy danh sách các môn học và đếm bài viết có status 'accept'
        $subjects = Subject::withCount(['posts' => function ($query) {
            $query->where('status', 'accept');
        }])->get();

        // Lấy danh sách bài viết, bao gồm tìm kiếm theo tên môn học hoặc gia sư
        $posts = Post::with(['giaSu.user', 'subject'])
            ->where('status', 'accept') // Lọc bài viết có trạng thái 'accept'
            ->when(request('area'), function ($query, $area) {
                // Lọc theo khu vực
                $query->whereHas('giaSu', function ($subQuery) use ($area) {
                    $subQuery->where('area', 'like', '%' . $area . '%');
                });
            })
            ->when($search, function ($query, $search) {
                // Tìm kiếm theo tên môn học hoặc tên gia sư
                $query->whereHas('subject', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('giaSu.user', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian tạo
            ->paginate(8); // Mỗi trang hiển thị 8 bài

        // Lấy bài viết ngẫu nhiên (không bị ảnh hưởng bởi tìm kiếm)
        $postsRandom = Post::with(['giaSu.user', 'subject'])
            ->where('status', 'accept')
            ->inRandomOrder() // Lấy ngẫu nhiên
            ->limit(2) // Giới hạn 2 bài
            ->get();

        return view('web.post.index', compact('posts', 'subjects', 'postsRandom'));
    }

    public function show($slug){
        Session::forget('post_id');
        // Tìm bài viết theo slug
        $post = Post::with(['giaSu.user', 'subject'])
            ->where('slug', $slug)
            ->where('status', 'accept') // Có thể kiểm tra status nếu cần
            ->first(); // Lấy bài viết đầu tiên khớp với slug
            
        if ($post) {
            $post->increment('views'); // Tăng trường `views` thêm 1
        }

        // Nếu không tìm thấy bài viết, có thể xử lý lỗi
        if (!$post) {
            abort(404, 'Bài viết không tồn tại');
        }

        $subjects = Subject::withCount(['posts' => function ($query) {
            $query->where('status', 'accept');
        }])->get();

        $postsRandom = Post::with(['giaSu.user', 'subject'])
            ->where('status', 'accept')
            ->inRandomOrder() // Lấy ngẫu nhiên
            ->limit(2) // Giới hạn 2 bài
            ->get(); // Lấy danh sách bài viết
        
        $newPost = Post::with(['giaSu.user', 'subject'])
        ->where('status', 'accept')
        ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian tạo
        ->paginate(10); // Mỗi trang hiển thị 10 bài

        $relatedPosts = Post::with(['giaSu.user', 'subject'])
        ->where('subject_id', $post->subject_id) // Lọc theo subject_id
        ->where('id', '!=', $post->id) // Loại trừ bài viết hiện tại
        ->where('status', 'accept') // Kiểm tra trạng thái bài viết
        ->inRandomOrder() // Lấy ngẫu nhiên
        ->take(3) // Giới hạn số lượng bài viết (ví dụ: 5 bài)
        ->get();

        $comments = Comment::with(['user.phuHuynh', 'user.giaSu'])
        ->where('post_id', $post->id)
        ->orderByDesc('id')
        ->get();

        $post_id = $post->id;
        $user_id = $post->user_id;

        return view('web.post.show', compact('post', 'subjects', 'postsRandom', 'newPost', 'relatedPosts', 'comments', 'post_id', 'user_id'));
    }
}
