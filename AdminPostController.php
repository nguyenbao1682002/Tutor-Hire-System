<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\GiaSu;
use App\Models\VipPackageDetail;
use App\Models\VipPackage;

class AdminPostController extends Controller
{

    public function index(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ yêu cầu
        $search = $request->input('search');

        // Lấy danh sách bài đăng
        $posts = Post::with(['giaSu.user', 'subject']) // Eager load GiaSu, User, và Subject
            ->when(auth()->user()->role === 'gia_su', function ($query) {
                // Nếu người dùng là gia_su, lọc theo user_id
                $query->whereHas('giaSu', function ($q) {
                    $q->where('user_id', auth()->user()->id);
                });
            })
            ->when($search, function ($query) use ($search) {
                // Điều kiện tìm kiếm theo tiêu đề bài viết
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('giaSu.user', function ($q) use ($search) {
                        // Tìm kiếm theo tên và email của user
                        $q->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('subject', function ($q) use ($search) {
                        // Tìm kiếm theo tên của subject
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate(10); // Điều chỉnh phân trang nếu cần
            
        $checkVip = $this->checkVip();

        return view('admin.post.index', compact('posts', 'search', 'checkVip'));
    }

    private function checkVip(){
        // Lấy thông tin gia sư hiện tại
        $giaSu = GiaSu::where('user_id', auth()->user()->id)->first();

        // Kiểm tra nếu gia sư không tồn tại
        if (!$giaSu) {
            return true;
        }

        // Lấy gói VIP của gia sư
        $vipPackage = VipPackage::where('gia_su_id', $giaSu->id)
                                ->where('end_date', '>', now()) // Kiểm tra gói VIP còn hạn
                                ->orderBy('end_date', 'desc') // Lấy gói VIP mới nhất
                                ->first();

        // Kiểm tra gói VIP còn hạn hay không
        if (!$vipPackage) {
            // Nếu không có gói VIP còn hạn, thông báo yêu cầu mua gói VIP
            return false;
        }

        // Lấy thông tin gói VIP chi tiết
        $vipPackageDetail = VipPackageDetail::find($vipPackage->vip_package_id);

        // Kiểm tra số bài đăng của gia sư
        $postsCount = Post::where('gia_su_id', $giaSu->id)
                        ->whereBetween('created_at', [$vipPackage->start_date, $vipPackage->end_date]) // Kiểm tra bài đăng trong thời gian gói VIP
                        ->count();

        if ($postsCount >= $vipPackageDetail->post_number) {
            return false;
        }

        return true;
    }

    public function create()
    {
        // Lấy thông tin gia sư hiện tại
        $giaSu = GiaSu::where('user_id', auth()->user()->id)->first();

        // Kiểm tra nếu gia sư không tồn tại
        if (!$giaSu) {
            return redirect()->route('admin.post.index')->with('error', 'Gia sư không tồn tại.');
        }

        // Lấy gói VIP của gia sư
        $vipPackage = VipPackage::where('gia_su_id', $giaSu->id)
                                ->where('end_date', '>', now()) // Kiểm tra gói VIP còn hạn
                                ->orderBy('end_date', 'desc') // Lấy gói VIP mới nhất
                                ->first();

        // Kiểm tra gói VIP còn hạn hay không
        if (!$vipPackage) {
            // Nếu không có gói VIP còn hạn, thông báo yêu cầu mua gói VIP
            return redirect()->route('admin.vip.index')->with('error', 'Bạn chưa dùng VIP hoặc gói VIP hết hạn. Vui lòng mua gói VIP mới.');
        }

        // Lấy thông tin gói VIP chi tiết
        $vipPackageDetail = VipPackageDetail::find($vipPackage->vip_package_id);

        // Kiểm tra số bài đăng của gia sư
        $postsCount = Post::where('gia_su_id', $giaSu->id)
                        ->whereBetween('created_at', [$vipPackage->start_date, $vipPackage->end_date]) // Kiểm tra bài đăng trong thời gian gói VIP
                        ->count();

        if ($postsCount >= $vipPackageDetail->post_number) {
            return redirect()->route('admin.vip.index')->with('error', 'Bạn đã đăng đủ số lượng bài cho gói vip. Vui lòng mua gói VIP mới.');
        }

        // Nếu tất cả điều kiện đều hợp lệ, tiếp tục thực hiện tạo bài
        $subjects = Subject::all();
        return view('admin.post.create', compact('subjects'));
    }


    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'description' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'fee' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Tối đa 2MB
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'slug.required' => 'Đường dẫn là bắt buộc.',
            'slug.string' => 'Đường dẫn phải là chuỗi ký tự.',
            'slug.max' => 'Đường dẫn không được vượt quá 255 ký tự.',
            'slug.unique' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác.',
            'description.required' => 'Nội dung mô tả là bắt buộc.',
            'description.string' => 'Nội dung mô tả phải là chuỗi ký tự.',
            'subject_id.required' => 'Bạn phải chọn một môn học.',
            'subject_id.exists' => 'Môn học bạn chọn không hợp lệ.',
            'fee.required' => 'Mức phí là bắt buộc.',
            'fee.numeric' => 'Mức phí phải là một số.',
            'fee.min' => 'Mức phí không được nhỏ hơn 0.',
            'image.image' => 'Hình ảnh phải là một tệp hình ảnh.',
            'image.mimes' => 'Hình ảnh chỉ được phép có các định dạng: jpeg, png, jpg, gif, svg.',
            'image.max' => 'Hình ảnh không được vượt quá 2MB.',
        ]);

        // Xử lý lưu hình ảnh (nếu có)
        $imagePath = $request->hasFile('image') 
            ? $request->file('image')->store('posts', 'public') 
            : null;

        $giaSuId = GiaSu::where('user_id', auth()->user()->id)->value('id');

        // Tạo bài viết mới
        Post::create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
            'subject_id' => $request->input('subject_id'),
            'fee' => $request->input('fee'),
            'gia_su_id' => $giaSuId, // Lấy ID gia sư hiện tại
            'user_id' => auth()->user()->id,
            'image' => $imagePath,
        ]);

        // Điều hướng với thông báo thành công
        return redirect()->route('admin.post.index')->with('success', 'Thêm bài viết mới thành công!');
    }


    public function show($id)
    {
        $post = Post::with('subject')->findOrFail($id);
        $subjects = Subject::all();
        return view('admin.post.show', compact('post', 'subjects'));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        if(auth()->user()->role == "gia_su"){
            // Validate dữ liệu
            $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:posts,slug,' . $id,
                'description' => 'required|string',
                'subject_id' => 'required|exists:subjects,id',
                'fee' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Tối đa 2MB
            ], [
                'title.required' => 'Tiêu đề là bắt buộc.',
                'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
                'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
                'slug.required' => 'Đường dẫn là bắt buộc.',
                'slug.string' => 'Đường dẫn phải là chuỗi ký tự.',
                'slug.max' => 'Đường dẫn không được vượt quá 255 ký tự.',
                'slug.unique' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác.',
                'description.required' => 'Nội dung mô tả là bắt buộc.',
                'description.string' => 'Nội dung mô tả phải là chuỗi ký tự.',
                'subject_id.required' => 'Bạn phải chọn một môn học.',
                'subject_id.exists' => 'Môn học bạn chọn không hợp lệ.',
                'fee.required' => 'Mức phí là bắt buộc.',
                'fee.numeric' => 'Mức phí phải là một số.',
                'fee.min' => 'Mức phí không được nhỏ hơn 0.',
                'image.image' => 'Hình ảnh phải là một tệp hình ảnh.',
                'image.mimes' => 'Hình ảnh chỉ được phép có các định dạng: jpeg, png, jpg, gif, svg.',
                'image.max' => 'Hình ảnh không được vượt quá 2MB.',
            ]);

            // Tìm bài viết cần cập nhật
            $post = Post::findOrFail($id);

            // Xóa hình ảnh cũ nếu có file ảnh mới được tải lên
            if ($request->hasFile('image')) {
                if ($post->image) {
                    \Storage::delete($post->image); // Xóa hình ảnh cũ
                }
                $imagePath = $request->file('image')->store('posts', 'public'); // Lưu hình ảnh mới
            } else {
                $imagePath = $post->image; // Giữ nguyên hình ảnh cũ
            }

            // Cập nhật bài viết
            $post->update([
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description'),
                'subject_id' => $request->input('subject_id'),
                'fee' => $request->input('fee'),
                'image' => $imagePath,
            ]);

            // Điều hướng với thông báo thành công
            return redirect()->route('admin.post.show', $id)->with('success', 'Cập nhật bài viết thành công!');
        }


        // Find the post by ID
        $post = Post::findOrFail($id);

        // Check if the status is not 'pending'
        if ($post->status != 'pending') {
            return redirect()->route('admin.post.index')->with('error', 'Không thể cập nhật trạng thái cho bài viết này.');
        }

        // Validate the incoming request data
        $request->validate([
            'status' => 'required|string|in:reject,accept|max:255',
        ], [
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.string' => 'Trạng thái phải là chuỗi ký tự.',
            'status.in' => 'Trạng thái phải là một trong những giá trị: reject, accept.',
            'status.max' => 'Trạng thái không được vượt quá 255 ký tự.',
        ]);

        // Update the post status
        $post->status = $request->input('status');
        $post->save(); // Save the changes

        // Redirect back to the post index with a success message
        return redirect()->route('admin.post.index')->with('success', $request->input('status') == 'reject' ? 'Đã từ chối bài viết' : 'Đã phê duyệt bài viết');
    }



    public function destroy($id)
    {
        //
    }
}
