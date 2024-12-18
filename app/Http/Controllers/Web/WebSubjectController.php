<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Post;

class WebSubjectController extends Controller
{
    public function show($slug){
        // Tìm kiếm Subject theo slug
        $subject = Subject::where('slug', $slug)->firstOrFail();

        // Lấy danh sách Subject cùng số lượng bài viết
        $subjects = Subject::withCount(['posts' => function ($query) {
            $query->where('status', 'accept');
        }])->get();

        // Lấy các bài viết thuộc Subject đã tìm thấy, chỉ lấy bài viết có status 'accept'
        $posts = Post::with(['giaSu.user', 'subject'])
            ->where('subject_id', $subject->id)
            ->where('status', 'accept')
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian tạo
            ->paginate(8); // Mỗi trang hiển thị 8 bài
        
        $bySubject = $subject->name;

        $postsRandom = Post::with(['giaSu.user', 'subject'])
            ->where('status', 'accept')
            ->inRandomOrder() // Lấy ngẫu nhiên
            ->limit(2) // Giới hạn 2 bài
            ->get(); // Lấy danh sách bài viết
        
        return view('web.post.index', compact('posts', 'subjects', 'bySubject', 'postsRandom'));
    }
}
