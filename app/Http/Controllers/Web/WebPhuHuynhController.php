<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\PhuHuynh;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class WebPhuHuynhController extends Controller
{
    public function show(Request $request){
        if(!auth()->user()){
            return redirect()->route('web.auth.login');
        }

        // Lấy giá trị tìm kiếm từ request
        $search = $request->input('search');

        // Query dữ liệu với phân trang và tìm kiếm
        $transactions = Transaction::with('user')
            ->when(auth()->user()->role === 'phu_huynh', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->when($search, function ($query, $search) {
                // Tìm kiếm theo tên người dùng hoặc email
                $query->whereHas('user', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Phân trang mỗi trang 10 dòng
            
        $user = User::findOrFail(auth()->user()->id);
        $phuhuynh = PhuHuynh::where('user_id', auth()->user()->id)->first();
        return view('web.phuhuynh.show', compact('transactions', 'user', 'phuhuynh'));
    }

    public function update(Request $request)
    {
        if(!auth()->user()){
            return redirect()->route('web.auth.login');
        }

        if(auth()->user()->role != "phu_huynh"){
            return redirect()->route('web.auth.login');
        }

        // Lấy người dùng hiện tại
        $user = auth()->user();

        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,11',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'old_password' => 'nullable|required_with:password,password2|string|min:4',
            'password' => 'nullable|string|min:4',
        ], [
            'name.required' => 'Họ tên là bắt buộc.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email đã tồn tại.',
            'old_password.required_with' => 'Bạn phải nhập mật khẩu cũ để đổi mật khẩu.',
            'password.min' => "Mật khẩu có ít nhất 4 ký tự",
        ]);

        if($request->input('password') != $request->input('password2')){
            return redirect()->back()->withErrors(['password' => 'Mật khẩu không trùng khớp.']);
        }

        // Cập nhật thông tin cá nhân
        $user->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
        ]);

        $phuhuynh = PhuHuynh::where('user_id', auth()->user()->id)->first();

        $phuhuynh->update([
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone'),
        ]);

        // Đổi mật khẩu nếu có
        if ($request->filled('password')) {
            if (Hash::check($request->input('old_password'), $user->password)) {
                $user->update([
                    'password' => Hash::make($request->input('password')),
                ]);
            } else {
                return redirect()->back()->withErrors(['old_password' => 'Mật khẩu cũ không đúng.']);
            }
        }

        // Chuyển hướng với thông báo thành công
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    } 

    public function pay(){
        if(!auth()->user()){
            return redirect()->route('web.auth.login');
        }

        if(auth()->user()->role == "gia_su"){
            return redirect()->route('admin.deposit.index');
        }
        return view('web.phuhuynh.pay');
    }

    public function payCheck(Request $request){
        if(!auth()->user()){
            return redirect()->route('web.auth.login');
        }

        if(auth()->user()->role == "gia_su"){
            return redirect()->route('admin.deposit.index');
        }

        $request->validate([
            'amount' => 'required|numeric|min:5000',
        ], [
            'amount.required' => 'Số tiền nạp là bắt buộc.',
            'amount.numeric' => 'Số tiền nạp phải là một số.',
            'amount.min' => 'Số tiền nạp phải lớn hơn hoặc bằng 5,000.',
        ]);

        // Lấy số tiền và bank_code từ form
        $amount = $request->amount;
        $bank_code = $request->input('bank_code'); // Ngân hàng

        // Các thông số kết nối với VNPAY
        $vnp_TmnCode = "UKSNYWZS"; //Website ID in VNPAY System
        $vnp_HashSecret = "9RYAAKDJNOQB8PWV0HVOY2BBN1O5HUFQ"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('web.phuhuynh.checkVnpay') . "?amount=" . $amount;
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";

        // Thời gian bắt đầu và hết hạn của giao dịch
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        // Mã đơn hàng, trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_TxnRef = time();
        $vnp_OrderInfo = "Thanh toán VNPAY";
        $vnp_OrderType = "order";
        $vnp_Amount = $amount * 100; // VNPAY yêu cầu số tiền tính bằng đơn vị tiền tệ là VND (tính bằng 100)
        $vnp_Locale = 'vn';

        $vnp_IpAddr = $request->ip(); // Lấy IP người dùng

        // Dữ liệu gửi lên VNPAY
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        // Nếu có mã ngân hàng thì thêm vào query
        if ($bank_code) {
            $inputData['vnp_BankCode'] = $bank_code;
        }

        // Sắp xếp dữ liệu theo thứ tự key
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";

        // Tạo chuỗi hash
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // URL của VNPAY
        $vnp_Url = $vnp_Url . "?" . $query;

        // Tạo hash bảo mật
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

        // Chuyển hướng đến VNPAY để thực hiện thanh toán
        return redirect($vnp_Url);
    }

    public function checkVnpay(Request $request){
        // Lấy tham số query vnp_ResponseCode và amount từ URL
        $responseCode = $request->query('vnp_ResponseCode');
        $amount = $request->query('amount');

        // Kiểm tra nếu vnp_ResponseCode = 00
        if ($responseCode == '00') {
            $phuHuynh = PhuHuynh::where('user_id', auth()->user()->id)->first();
            if ($phuHuynh) {
                // Cập nhật balance của GiaSu
                $phuHuynh->balance += $amount; // Cộng số tiền từ payment vào balance
                $phuHuynh->save();

                // Lưu lịch sử giao dịch
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'amount' => $amount,
                    'description' => "Phụ huynh " . auth()->user()->fullname . " nạp " . number_format($amount) . " vào tài khoản!"
                ]);

                // Quay lại trang web.phuhuynh.pay với thông báo thành công
                return redirect()->route('web.phuhuynh.pay')
                    ->with('success', 'Nạp thành công ' . number_format($amount) . ' VND vào tài khoản');
            }
        }

        return redirect()->route('web.phuhuynh.pay');
    }
}
