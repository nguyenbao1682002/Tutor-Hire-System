<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\GiaSu;

class AdminDepositController extends Controller
{
    public function index(Request $request)
    {
        $balance = GiaSu::where('user_id', auth()->user()->id)->value('balance');

        // Lấy giá trị tìm kiếm từ request
        $search = $request->input('search');

        // Query dữ liệu với phân trang và tìm kiếm
        $transactions = Transaction::with('user')
            ->when(auth()->user()->role === 'gia_su', function ($query) {
                // Nếu người dùng có vai trò gia_su, lọc theo user_id = auth()->user()->id
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

        // Trả về view với dữ liệu
        return view('admin.deposit.index', compact('transactions', 'search', 'balance'));
    }

    public function pay(Request $request)
    {
        // Kiểm tra giá trị 'sotien' có hợp lệ không và >= 5000
        $request->validate([
            'sotien' => 'required|numeric|min:5000', // Kiểm tra có phải là số và >= 5000
        ], [
            'sotien.required' => 'Số tiền là bắt buộc.',
            'sotien.numeric' => 'Số tiền phải là một số hợp lệ.',
            'sotien.min' => 'Số tiền phải lớn hơn hoặc bằng 5000 vnd.',
        ]);

        // Lấy số tiền và bank_code từ form
        $amount = $request->input('sotien');
        $bank_code = $request->input('bank_code'); // Ngân hàng

        // Các thông số kết nối với VNPAY
        $vnp_TmnCode = "UKSNYWZS"; //Website ID in VNPAY System
        $vnp_HashSecret = "9RYAAKDJNOQB8PWV0HVOY2BBN1O5HUFQ"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('admin.deposit.vnpayReturn') . "?amount=" . $amount;
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

    public function vnpayReturn(Request $request)
    {
        // Lấy tham số query vnp_ResponseCode và amount từ URL
        $responseCode = $request->query('vnp_ResponseCode');
        $amount = $request->query('amount');

        // Kiểm tra nếu vnp_ResponseCode = 00
        if ($responseCode == '00') {
            // Lấy GiaSu của người dùng hiện tại
            $giaSu = GiaSu::where('user_id', auth()->user()->id)->first();

            if ($giaSu) {
                // Cập nhật balance của GiaSu
                $giaSu->balance += $amount; // Cộng số tiền từ payment vào balance
                $giaSu->save();

                // Lưu lịch sử giao dịch
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'amount' => $amount,
                    'description' => "Gia sư " . auth()->user()->fullname . " nạp " . number_format($amount) . " vào tài khoản!"
                ]);

                // Quay lại trang admin.deposit.index với thông báo thành công
                return redirect()->route('admin.deposit.index')
                    ->with('success', 'Nạp thành công ' . number_format($amount) . ' VND vào tài khoản');
            }
        }

        // Nếu vnp_ResponseCode không phải 00, quay lại admin.deposit.index mà không có thông báo
        return redirect()->route('admin.deposit.index');
    }
    
}
