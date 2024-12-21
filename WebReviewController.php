<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PhuHuynh;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\GiaSu;

class WebReviewController extends Controller
{
    public function post(Request $request)
    {
        $phu_huynh_id = PhuHuynh::with('user')->where('user_id', auth()->user()->id)->first()->id;

        $phu_huynh_id = PhuHuynh::with('user')->where('user_id', auth()->user()->id)->first()->id;
        $gia_su_id = $request->gia_su_id;
        $rating = $request->rating;

        // Kiểm tra phụ huynh đã đánh giá gia sư chưa
        $review = Review::where('phu_huynh_id', $phu_huynh_id)->where('gia_su_id', $gia_su_id)->first();

        if ($review) {
            // Nếu đã đánh giá, cập nhật rating
            $review->update(['rating' => $rating]);
        } else {
            // Nếu chưa đánh giá, thêm đánh giá mới
            Review::create([
                'phu_huynh_id' => $phu_huynh_id,
                'gia_su_id' => $gia_su_id,
                'rating' => $rating,
            ]);
        }

        // Tính toán lại tổng rating và số lượng đánh giá
        $reviews = Review::where('gia_su_id', $gia_su_id)->get();
        $review_count = $reviews->count();
        $new_rating = $reviews->avg('rating'); // Trung bình rating

        // Cập nhật rating và review_count trong GiaSu
        $giaSu = GiaSu::find($gia_su_id);
        $giaSu->update([
            'rating' => $new_rating,
            'review_count' => $review_count,
        ]);

        return response()->json(['message' => 'Đánh giá đã được lưu thành công!', 'rating' => $new_rating, 'review_count' => $review_count]);
    }
}
