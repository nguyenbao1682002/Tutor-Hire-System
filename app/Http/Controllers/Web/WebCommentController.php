<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class WebCommentController extends Controller
{
    public function post(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'post_id' => 'required|exists:posts,id', // Kiểm tra nếu post_id hợp lệ
        ]);

        // Tạo bình luận mới
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $request->post_id;
        $comment->save();

        // Eager load phuHuynh và giaSu để lấy avatar
        $comment = Comment::with(['user.phuHuynh', 'user.giaSu'])
            ->where('id', $comment->id)
            ->firstOrFail();

        // Kiểm tra nếu bình luận là của phụ huynh hay gia sư và lấy avatar
        $avatar = null;
        if ($comment->user->phuHuynh) {
            $avatar = $comment->user->phuHuynh->avatar;  // Avatar của phụ huynh
        } elseif ($comment->user->giaSu) {
            $avatar = $comment->user->giaSu->avatar;  // Avatar của gia sư
        }

        // Trả về dữ liệu bình luận với avatar
        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'user_name' => $comment->user->name,
                'avatar' => empty($avatar) ? asset('assets/imgs/avatar.png') : asset('storage/' . $avatar),
                'created_at' => $comment->created_at->format('d M Y'),
            ],
        ]);
    }
}
