<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\GiaSu;

class AdminCommentController extends Controller
{
    /**
     * Hiển thị danh sách các bình luận
     */
    public function index(Request $request)
    {
        // Lấy từ khóa tìm kiếm (nếu có)
        $search = $request->input('search');

        // Lấy danh sách bình luận cùng thông tin người dùng và bài viết
        $comments = Comment::with(['user', 'post'])
            ->when(auth()->user()->role === 'gia_su', function ($query) {
                // Nếu người dùng là gia_su, lấy các bình luận có post.user_id = auth()->user()->id
                $query->whereHas('post', function ($q) {
                    $q->where('user_id', auth()->user()->id);
                });
            })
            ->when($search, function ($query) use ($search) {
                // Tìm kiếm theo tên người dùng hoặc nội dung bình luận
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })->orWhere('content', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.comment.index', compact('comments', 'search'));
    }

    /**
     * Xóa bình luận
     */
    public function destroy($id)
    {
        // Tìm và xóa bình luận
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('admin.comment.index')->with('success', 'Bình luận đã được xóa thành công.');
    }
}
