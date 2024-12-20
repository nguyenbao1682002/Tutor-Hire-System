<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GiaSu;
use App\Models\User;

class AdminTutorController extends Controller
{
    /**
     * Display a listing of the tutors, with pagination and search.
     */
    public function index(Request $request)
    {
        // Tìm kiếm theo tên hoặc email của user liên kết với gia sư
        $search = $request->input('search');

        // Lấy danh sách gia sư với phân trang và tìm kiếm
        $tutors = GiaSu::with('user')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10);

        return view('admin.tutor.index', compact('tutors', 'search'));
    }


    /**
     * Show the form for creating a new tutor.
     */
    public function create()
    {
        return view('admin.tutor.create');
    }

    /**
     * Store a newly created tutor in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:4',
            'fee' => 'nullable|numeric',
            'province_text' => 'required',
            'district_text' => 'required'
        ], [
            'name.required' => 'Tên không được để trống.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại trong hệ thống.',
        
            'password.required' => 'Mật khẩu không được để trống.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 4 ký tự.',
        
            'fee.numeric' => 'Phí phải là số.',
        
            'province_text.required' => 'Vui lòng chọn Tỉnh/Thành phố.',
            'district_text.required' => 'Vui lòng chọn Quận/Huyện.'        
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'gia_su'
        ]);
    
        GiaSu::create([
            'user_id' => $user->id,
            'rating' => 0,
            'review_count' => 0,
            'fee' => $request->fee,
            'area' => empty($request->ward_text) ? "{$request->district_text}, {$request->province_text}" : "{$request->ward_text}, {$request->district_text}, {$request->province_text}", // Lưu địa chỉ
            'post_status' => false
        ]);

        return redirect()->route('admin.tutor.index')->with('success', 'Tạo thông tin gia sư thành công.');
    }

    /**
     * Show the form for editing the specified tutor.
     */
    public function edit($id)
    {
        $tutor = GiaSu::with('user')->findOrFail($id);
        return view('admin.tutor.edit', compact('tutor'));
    }

    /**
     * Update the specified tutor in storage.
     */
    public function update(Request $request, $id)
    {
        $tutor = GiaSu::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $tutor->user_id,
            'password' => 'nullable|string|min:4',
            'fee' => 'nullable|numeric',
            'province_text' => 'required',
            'district_text' => 'required'
        ], [
            'name.required' => 'Tên không được để trống.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại trong hệ thống.',
        
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 4 ký tự.',
        
            'fee.numeric' => 'Phí phải là số.',
        
            'province_text.required' => 'Vui lòng chọn Tỉnh/Thành phố.',
            'district_text.required' => 'Vui lòng chọn Quận/Huyện.'        
        ]);

        // Cập nhật thông tin tài khoản gia sư
        $tutor->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $tutor->user->password,
        ]);

        // Cập nhật thông tin gia sư
        $tutor->update([
            'fee' => $request->fee,
            'area' => empty($request->ward_text) ? "{$request->district_text}, {$request->province_text}" : "{$request->ward_text}, {$request->district_text}, {$request->province_text}"
        ]);

        return redirect()->route('admin.tutor.index')->with('success', 'Lưu thông tin gia sư thành công.');
    }

    /**
     * Remove the specified tutor from storage.
     */
    public function destroy($id)
    {
        $tutor = GiaSu::findOrFail($id);
        $tutor->user()->delete(); // Xóa tài khoản user của gia sư
        $tutor->delete(); // Xóa bản ghi gia sư

        return redirect()->route('admin.tutor.index')->with('success', 'Xóa thông tin gia sư thành công.');
    }
}