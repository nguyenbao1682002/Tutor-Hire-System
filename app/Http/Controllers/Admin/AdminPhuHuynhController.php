<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhuHuynh;

class AdminPhuHuynhController extends Controller
{
    public function index(Request $request)
    {
        // Tìm kiếm theo tên hoặc email của user liên kết với phụ huynh
        $search = $request->input('search');

        // Lấy danh sách phụ huynh với phân trang và tìm kiếm
        $phuhuynhs = PhuHuynh::with(['user'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone_number', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10);

        return view('admin.phuhuynh.index', compact('phuhuynhs', 'search'));
    }


    public function show($id){
        $phuhuynh = PhuHuynh::with('user')->findOrFail($id);
        return view('admin.phuhuynh.show', compact('phuhuynh'));
    }

    public function balance(Request $request, $id){
        $phuhuynh = PhuHuynh::findOrFail($id);

        $request->validate([
            'action' => 'required|string|in:add,sub|max:3',
            'balance' => 'required|numeric|min:1000'
        ], [
            'action.required' => 'Hành động là bắt buộc.',
            'action.string' => 'Hành động không hợp lệ.',
            'action.in' => 'Hành động không hợp lệ',
            'action.max' => 'Hành động không hợp lệ.',
            
            'balance.required' => 'Số tiền là bắt buộc.',
            'balance.min' => 'Số tiền tối thiểu 1000đ.',
            'balance.numeric' => 'Số tiền không hợp lệ.',
        ]);

        if($request->balance > 100000000){
            return redirect()->route('admin.phuhuynh.show', $id)->with('error', 'Vượt quá số số tiền tối đa trong 1 lần.'); 
        }

        if($request->action == 'add'){
            $phuhuynh->balance = $phuhuynh->balance + $request->balance;
            $phuhuynh->save();
            return redirect()->route('admin.phuhuynh.show', $id)->with('success', 'Cộng tiền '. number_format($request->balance) .'đ vào số dư phụ huynh thành công!'); 
        }else{
            if($phuhuynh->balance <= 0){
                return redirect()->route('admin.phuhuynh.show', $id)->with('error', 'Số dư không đủ để thực hiện TRỪ TIỀN!'); 
            }

            if($request->balance > $phuhuynh->balance){
                return redirect()->route('admin.phuhuynh.show', $id)->with('error', 'Số dư không đủ để thực hiện TRỪ TIỀN!'); 
            }

            $phuhuynh->balance = $phuhuynh->balance - $request->balance;
            $phuhuynh->save();
            return redirect()->route('admin.phuhuynh.show', $id)->with('success', 'Trừ tiền '. number_format($request->balance) .'đ vào số dư phụ huynh thành công!'); 
        }

    }

    public function block($id)
    {
        // Tìm phụ huynh theo ID
        $phuhuynh = PhuHuynh::findOrFail($id);

        // Đổi trạng thái (block hoặc unblock)
        $phuhuynh->status = $phuhuynh->status == 0 ? 1 : 0;

        // Lưu lại thay đổi vào cơ sở dữ liệu
        $phuhuynh->save();

        // Chuyển hướng về trang danh sách phụ huynh
        return redirect()->route('admin.phuhuynh.index')->with('success', 'Cập nhật trạng thái thành công!');
    }

}
