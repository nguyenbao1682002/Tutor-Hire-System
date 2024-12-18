<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\GiaSu;
use App\Models\PhuHuynh;
use App\Models\User;
use App\Models\VipPackage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\Review;



class WebTutorController extends Controller
{
    public function show(Request $request, $id){
        Session::forget('user_id');
        
        $giasu = GiaSu::with('user')->where('user_id', $id)->first();

        $posts = Post::with(['giaSu.user', 'subject'])
        ->where('status', 'accept')
        ->where('user_id', $id)
        ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian tạo
        ->paginate(10); // Mỗi trang hiển thị 10 bài

        $newPost = Post::with(['giaSu.user', 'subject'])
        ->where('status', 'accept')
        ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian tạo
        ->paginate(8); // Mỗi trang hiển thị 10 bài

        // Lấy tất cả đánh giá của gia sư dựa trên gia_su_id
        $reviews = Review::where('gia_su_id', $giasu->id)->get();

        // Tính tổng số sao
        $totalRating = $reviews->sum('rating');

        // Tính số đánh giá trung bình trên 5 (nếu có đánh giá)
        $averageRating = $reviews->count() > 0 ? $totalRating / $reviews->count() : 0;

        $countRating = $reviews->count();

        return view('web.profile.index', compact('giasu', 'posts', 'newPost', 'reviews', 'totalRating', 'averageRating', 'countRating'));
    }

    public function phone(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        if(!auth()->user()){
            if(isset($request->post_id) && !empty($request->post_id)){
                Session::put('post_id', $request->post_id);
            }else if(!isset($request->post_id) && isset($request->user_id)){
                Session::put('user_id', $request->user_id);
            }
            
            echo "Vui lòng đăng nhập để xem thông tin liên hệ!";
            return;
        }

        if(auth()->user()->role != "phu_huynh"){
            echo "Phụ huynh mới được phép xem thông tin liên hệ!";
            return;
        }


        $phuHuynh = PhuHuynh::where('user_id', auth()->id())->first();
        $vipPackage = VipPackage::where('phu_huynh_id', $phuHuynh->id)
        ->where('end_date', '>=', Carbon::now()) // Kiểm tra hạn còn hiệu lực
        ->first();

        if ($vipPackage) {
            $user = User::findOrFail($request->user_id);
            echo $user->phone;
        } else {
            echo "Vui lòng mua VIP để xem thông tin liên hệ gia sư!";
            return;
        }
    }
}
