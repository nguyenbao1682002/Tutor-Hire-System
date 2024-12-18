<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VipPackage;
use App\Models\VipPackageDetail;
use App\Models\PhuHuynh;
use App\Models\Transaction;


class WebVipPackageDetailController extends Controller
{
    public function show(Request $request){
        if(!auth()->user()){
            return redirect()->route('web.auth.login');
        }

        if(auth()->user()->role != "phu_huynh"){
            return redirect()->route('admin.vip.index');
        }

        // Nhận từ khóa tìm kiếm từ request
        $search = $request->input('search');

        // Lấy danh sách các gói VIP
        $vipPackages = VipPackageDetail::when($search, function ($query) use ($search) {
            $query->where('package_type', 'like', '%' . $search . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(10); // Phân trang 10 bản ghi

        // Lấy ID của gia sư hiện tại
        $phuHuynhId = PhuHuynh::where('user_id', auth()->user()->id)->value('id');

        // Duyệt qua từng gói VIP để kiểm tra trạng thái
        $vipPackages->getCollection()->transform(function ($vipPackageDetail) use ($phuHuynhId) {
            // Kiểm tra xem gói VIP này có đang được gia sư sử dụng hay không
            $vipPackage = VipPackage::where('phu_huynh_id', $phuHuynhId)
                ->where('vip_package_id', $vipPackageDetail->id)
                ->where('end_date', '>', now()) // Chỉ lấy gói còn hạn sử dụng
                ->first();

            // Đặt trạng thái is_active dựa trên điều kiện
            $vipPackageDetail->is_active = $vipPackage ? true : false;

            return $vipPackageDetail;
        });
        return view('web.vip.show', compact('vipPackages', 'search'));
    }

    public function register($vipPackageId){
        if(!auth()->user()){
            return redirect()->route('web.auth.login');
        }

        if(auth()->user()->role != "phu_huynh"){
            return redirect()->route('admin.vip.index');
        }

        // Lấy thông tin gia sư hiện tại
        $phuHuynh = PhuHuynh::where('user_id', auth()->user()->id)->first();

        // Kiểm tra xem gia sư có đủ số dư không
        $vipPackageDetail = VipPackageDetail::find($vipPackageId);

        if ($phuHuynh && $vipPackageDetail) {
            if ($phuHuynh->balance >= $vipPackageDetail->price) {
                // Trừ số tiền của gia sư
                $phuHuynh->balance -= $vipPackageDetail->price;
                $phuHuynh->save();

                // Lưu lịch sử giao dịch
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'amount' => -$vipPackageDetail->price, // Số tiền bị trừ
                    'description' => "Hệ thống trừ " . number_format($vipPackageDetail->price, 0, ',', '.') . " phụ huynh mua gói VIP: " . $vipPackageDetail->package_type
                ]);

                VipPackage::where('phu_huynh_id', $phuHuynh->id)->delete();

                // Đăng ký gói VIP mới cho gia sư
                $newVipPackage = VipPackage::create([
                    'phu_huynh_id' => $phuHuynh->id,
                    'package_type' => $vipPackageDetail->package_type,
                    'start_date' => now(),
                    'end_date' => now()->addDays($vipPackageDetail->duration_days),
                    'vip_package_id' => $vipPackageDetail->id,
                ]);

                // Quay lại trang quản lý gói VIP với thông báo thành công
                return redirect()->route('web.vip.show')->with('success', 'Đăng ký gói VIP thành công và trừ tiền thành công!');
            } else {
                // Nếu gia sư không đủ số dư
                return redirect()->route('web.vip.show')->with('error', 'Số dư của bạn không đủ để mua gói VIP!');
            }
        }

        return redirect()->route('web.vip.show')->with('error', 'Không tìm thấy gia sư hoặc gói VIP!');
    }
}
