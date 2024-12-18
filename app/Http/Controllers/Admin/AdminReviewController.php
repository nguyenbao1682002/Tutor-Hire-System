<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\GiaSu;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        // Lấy từ khóa tìm kiếm
        $search = $request->input('search');

        // Kiểm tra vai trò của người dùng
        $reviews = Review::with(['giaSu.user', 'phuHuynh.user']) // Eager load
            ->when(auth()->user()->role === 'gia_su', function ($query) {
                // Nếu vai trò là 'gia_su', lấy gia_su_id dựa trên user_id
                $giaSuId = GiaSu::where('user_id', auth()->user()->id)->value('id');
                $query->where('gia_su_id', $giaSuId);
            })
            ->when($search, function ($query) use ($search) {
                // Áp dụng tìm kiếm
                $query->whereHas('phuHuynh.user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('giaSu.user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.review.index', compact('reviews', 'search'));
    }

    public function destroy($id)
    {
        // Tìm và xóa đánh giá
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.review.index')->with('success', 'Đánh giá đã được xóa thành công.');
    }
}
