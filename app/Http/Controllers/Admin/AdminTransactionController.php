<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        // Lấy giá trị tìm kiếm từ request
        $search = $request->input('search');

        // Query dữ liệu với phân trang và tìm kiếm
        $transactions = Transaction::with('user')
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%$search%")
                             ->orWhere('email', 'like', "%$search%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(50); // Phân trang mỗi trang 10 dòng

        // Trả về view với dữ liệu
        return view('admin.transaction.index', compact('transactions', 'search'));
    }
}
