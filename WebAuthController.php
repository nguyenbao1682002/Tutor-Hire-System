<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\GiaSu;
use App\Models\PhuHuynh;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class WebAuthController extends Controller
{
    public function login(Request $request){
        if(!empty($request->input('post_id')) && $request->input('post_id') != "" && is_numeric($request->input('post_id'))){
            Session::put('post_id', $request->input('post_id'));
        }
        return view('web.auth.login');
    }

    public function submitLogin(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        if (Auth::attempt($credentials)) {
            if (auth()->user()->role == 'phu_huynh') {
                $checkPhuHuynh = PhuHuynh::where('status', 0)
                ->where('user_id', auth()->user()->id)
                ->count();
                if($checkPhuHuynh > 0){
                    Auth::logout();
                    return redirect()->route('web.auth.login')->withErrors(['error' => 'Không thể đăng nhập! Lý do: Phụ huynh bị chặn khỏi hệ thống!']);
                }else{
                    if (Session::has('post_id')) {
                        $post_id = Session::get('post_id');
                        $post = Post::findOrFail($post_id);
                        Session::forget('post_id');
                        return redirect()->route('web.post.show', $post->slug);
                    }else if(Session::has('user_id')){
                        $user_id = Session::get('user_id');
                        Session::forget('user_id');
                        return redirect()->route('web.giasu.show', $user_id);
                    }

                    return redirect()->intended('/phu-huynh');
                }
            } else if(auth()->user()->role == 'gia_su') {
                return redirect()->route('web.giasu.show', auth()->user()->id);
            }else{
                return redirect()->intended('/admin');
            }
        }
    
        // Đăng nhập thất bại
        return redirect()->route('web.auth.login')->withErrors(['error' => 'Đăng nhập không thành công. Vui lòng kiểm tra lại thông tin đăng nhập.']);
    }

    public function tutorRegister(){
        return view('web.auth.tutorRegister'); 
    }

    public function tutorRegisterSubmit(Request $request)
    {
        // Xác thực dữ liệu từ form
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:11',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
            'province_text' => 'required|string',
            'district_text' => 'required|string',
            'ward_text' => 'nullable|string',
            'fee' => 'required|numeric|min:0',
            'years_of_experience' => 'required|integer|min:1',
            'education_level' => 'required|string',
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'bio' => 'nullable|string|max:150',
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'name.string' => 'Họ tên phải là chuỗi ký tự.',
            'name.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.string' => 'Số điện thoại phải hợp lệ.',
            'phone.max' => 'Số điện thoại không được vượt quá 11 số.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 4 ký tự.',
            'province_text.required' => 'Vui lòng chọn tỉnh/thành phố.',
            'district_text.required' => 'Vui lòng chọn quận/huyện.',
            'fee.required' => 'Vui lòng nhập mức phí.',
            'fee.numeric' => 'Mức phí phải là số.',
            'fee.min' => 'Mức phí phải lớn hơn hoặc bằng 0.',
            'years_of_experience.required' => 'Vui lòng nhập số năm kinh nghiệm.',
            'years_of_experience.integer' => 'Số năm kinh nghiệm phải là số nguyên.',
            'years_of_experience.min' => 'Số năm kinh nghiệm phải lớn hơn hoặc bằng 1.',
            'education_level.required' => 'Vui lòng chọn trình độ.',
            'avatar.required' => 'Vui lòng tải lên ảnh đại diện.',
            'avatar.image' => 'Ảnh đại diện phải là tệp hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, hoặc jpg.',
            'avatar.max' => 'Kích thước ảnh đại diện không được vượt quá 2MB.',
            'bio.max' => 'Giới thiệu không được vượt quá 150 ký tự.',
            'district_text.string' => 'Quận huyện không hợp lệ',
            'province_text.string' => 'Tỉnh thành không hợp lệ',
        ]);

        // Tạo tài khoản người dùng (User)
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'gia_su', // Đặt vai trò là "gia_sư"
            'phone' => $validatedData['phone'],
        ]);

        // Xử lý ảnh đại diện (nếu có)
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Tạo bản ghi Gia Sư
        GiaSu::create([
            'user_id' => $user->id,
            'fee' => $validatedData['fee'],
            'area' => $validatedData['ward_text'] . ', ' . $validatedData['district_text'] . ', ' . $validatedData['province_text'],
            'years_of_experience' => $validatedData['years_of_experience'],
            'education_level' => $validatedData['education_level'],
            'bio' => $validatedData['bio'],
            'avatar' => $avatarPath,
            'rating' => 0,
            'review_count' => 0,
            'post_status' => 0,
            'balance' => 0, // Số dư ban đầu
        ]);

        Auth::login($user);

        // Chuyển hướng sau khi đăng ký thành công
        return redirect()->route('web.giasu.show', $user->id)->with('success', 'Đăng ký gia sư thành công!');
    }

    public function parentRegister(){
        return view('web.auth.parentRegister'); 
    }

    public function parentRegisterSubmit(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.'
        ]);

        // 2. Tạo người dùng mới
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'phu_huynh', // Đặt vai trò là "phu_huynh"
            'phone' => $validatedData['phone']
        ]);

        PhuHuynh::create([
            'user_id' => $user->id,
            'vip_package' => '', // Giá trị mặc định hoặc tuỳ chỉnh
            'balance' => 0, // Giá trị mặc định hoặc tuỳ chỉnh
            'phone_number' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'status' => 1, // Giá trị mặc định hoặc tuỳ chỉnh
        ]);

        // 3. Đăng nhập người dùng mới (nếu cần)
        Auth::login($user);

        // 4. Redirect đến trang phụ huynh hoặc trang khác
        return redirect('/phu-huynh')->with('success', 'Đăng ký thành công. Bạn đã được đăng nhập.');
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('web.auth.login');
    }
}
