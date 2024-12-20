<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VipPackageDetail;
use App\Models\VipPackage;
use App\Models\GiaSu;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminVipPackageDetailController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role == "gia_su") {
            // Nhận từ khóa tìm kiếm từ request
            $search = $request->input('search');

            // Lấy danh sách các gói VIP
            $vipPackages = VipPackageDetail::when($search, function ($query) use ($search) {
                $query->where('package_type', 'like', '%' . $search . '%');
            })
                ->orderBy('id', 'desc')
                ->paginate(10); // Phân trang 10 bản ghi

            // Lấy ID của gia sư hiện tại
            $giaSuId = GiaSu::where('user_id', auth()->user()->id)->value('id');

            // Duyệt qua từng gói VIP để kiểm tra trạng thái
            $vipPackages->getCollection()->transform(function ($vipPackageDetail) use ($giaSuId) {
                // Kiểm tra xem gói VIP này có đang được gia sư sử dụng hay không
                $vipPackage = VipPackage::where('gia_su_id', $giaSuId)
                    ->where('vip_package_id', $vipPackageDetail->id)
                    ->where('end_date', '>', now()) // Chỉ lấy gói còn hạn sử dụng
                    ->first();

                // Đặt trạng thái is_active dựa trên điều kiện
                $vipPackageDetail->is_active = $vipPackage ? true : false;

                return $vipPackageDetail;
            });

            // Trả về view với dữ liệu
            return view('admin.vip.show', compact('vipPackages', 'search'));
        }

        // Nhận từ khóa tìm kiếm từ request
        $search = $request->input('search');

        // Lấy các gói VIP, lọc theo tên nếu có từ khóa tìm kiếm
        $vipPackages = VipPackageDetail::when($search, function ($query) use ($search) {
            $query->where('package_type', 'like', '%' . $search . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(10); // Phân trang 10 bản ghi

        return view('admin.vip.index', compact('vipPackages', 'search'));
    }

    public function create()
    {
        return view('admin.vip.create');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'package_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'post_number' => 'required|integer|min:1',
            'benefits' => 'nullable|string',
        ], [
            'package_type.required' => 'Loại gói VIP là bắt buộc.',
            'package_type.string' => 'Loại gói VIP phải là chuỗi ký tự.',
            'package_type.max' => 'Loại gói VIP không được vượt quá 255 ký tự.',
            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá không được nhỏ hơn 0.',
            'duration_days.required' => 'Số ngày hiệu lực là bắt buộc.',
            'duration_days.integer' => 'Số ngày hiệu lực phải là số nguyên.',
            'duration_days.min' => 'Số ngày hiệu lực phải lớn hơn hoặc bằng 1.',
            'post_number.required' => 'Số bài đăng là bắt buộc.',
            'post_number.integer' => 'Số bài đăng phải là số nguyên.',
            'post_number.min' => 'Số bài đăng tối thiểu là 1.',
            'benefits.string' => 'Lợi ích phải là chuỗi ký tự.',
        ]);

        // Lưu gói VIP
        VipPackageDetail::create($request->all());

        return redirect()->route('admin.vip.index')->with('success', 'Gói VIP đã được thêm thành công.');
    }

    public function show($id)
    {
        $vip = VipPackageDetail::findOrFail($id);
        return view('admin.vip.show', compact('vip'));
    }

    public function edit($id)
    {
        $vip = VipPackageDetail::findOrFail($id);
        return view('admin.vip.edit', compact('vip'));
    }

    public function update(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'package_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'post_number' => 'required|integer|min:1',
            'benefits' => 'nullable|string',
        ], [
            'package_type.required' => 'Loại gói VIP là bắt buộc.',
            'package_type.string' => 'Loại gói VIP phải là chuỗi ký tự.',
            'package_type.max' => 'Loại gói VIP không được vượt quá 255 ký tự.',
            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá không được nhỏ hơn 0.',
            'duration_days.required' => 'Số ngày hiệu lực là bắt buộc.',
            'duration_days.integer' => 'Số ngày hiệu lực phải là số nguyên.',
            'duration_days.min' => 'Số ngày hiệu lực phải lớn hơn hoặc bằng 1.',
            'post_number.required' => 'Số bài đăng là bắt buộc.',
            'post_number.integer' => 'Số bài đăng phải là số nguyên.',
            'post_number.min' => 'Số bài đăng tối thiểu là 1.',
            'benefits.string' => 'Lợi ích phải là chuỗi ký tự.',
        ]);

        // Cập nhật gói VIP
        $vipPackage = VipPackageDetail::findOrFail($id);
        $vipPackage->update($request->all());

        return redirect()->route('admin.vip.index')->with('success', 'Gói VIP đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $vipPackage = VipPackageDetail::findOrFail($id);
        $vipPackage->delete();

        return redirect()->route('admin.vip.index')->with('success', 'Gói VIP đã được xóa thành công.');
    }

    public function register($vipPackageId)
    {
        // Lấy thông tin gia sư hiện tại
        $giaSu = GiaSu::where('user_id', auth()->user()->id)->first();

        // Kiểm tra xem gia sư có đủ số dư không
        $vipPackageDetail = VipPackageDetail::find($vipPackageId);

        if ($giaSu && $vipPackageDetail) {
            if ($giaSu->balance >= $vipPackageDetail->price) {
                // Trừ số tiền của gia sư
                $giaSu->balance -= $vipPackageDetail->price;
                $giaSu->save();

                // Lưu lịch sử giao dịch
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'amount' => -$vipPackageDetail->price, // Số tiền bị trừ
                    'description' => "Hệ thống trừ " . number_format($vipPackageDetail->price, 0, ',', '.') . " gia sư mua gói VIP: " . $vipPackageDetail->package_type
                ]);

                // Xóa hết các gói VIP cũ của gia sư (nếu có)
                VipPackage::where('gia_su_id', $giaSu->id)->delete();

                // Đăng ký gói VIP mới cho gia sư
                $newVipPackage = VipPackage::create([
                    'gia_su_id' => $giaSu->id,
                    'package_type' => $vipPackageDetail->package_type,
                    'start_date' => now(),
                    'end_date' => now()->addDays($vipPackageDetail->duration_days),
                    'vip_package_id' => $vipPackageDetail->id,
                ]);

                // Quay lại trang quản lý gói VIP với thông báo thành công
                return redirect()->route('admin.vip.index')->with('success', 'Đăng ký gói VIP thành công và trừ tiền thành công!');
            } else {
                // Nếu gia sư không đủ số dư
                return redirect()->route('admin.deposit.index')->with('error', 'Số dư của bạn không đủ để mua gói VIP!');
            }
        }

        return redirect()->route('admin.vip.index')->with('error', 'Không tìm thấy gia sư hoặc gói VIP!');
    }

}
