<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class AdminSubjectController extends Controller
{

    public function index(Request $request)
    {
        // Nhận từ khóa tìm kiếm từ request
        $search = $request->input('search');

        // Lấy các môn học, lọc theo tên nếu có từ khóa tìm kiếm
        $subjects = Subject::when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10); // Phân trang 10 bản ghi

        return view('admin.subject.index', compact('subjects', 'search'));
    }
 
    public function create()
    {
        return view('admin.subject.create');
    }


    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'slug' => 'required|string|max:255|unique:subjects,slug',
        ], [
            'name.required' => 'Tên môn học là bắt buộc.',
            'name.string' => 'Tên môn học phải là chuỗi ký tự.',
            'name.max' => 'Tên môn học không được vượt quá 255 ký tự.',
            'image.required' => 'Ảnh môn học là bắt buộc.',
            'image.image' => 'Ảnh phải là định dạng hình ảnh.',
            'image.mimes' => 'Ảnh chỉ được phép có các định dạng: jpeg, png, jpg, gif, svg.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.string' => 'Slug phải là chuỗi ký tự.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại. Vui lòng chọn slug khác.',
        ]);

        // Lưu môn học
        Subject::create([
            'name' => $request->input('name'),
            'image' => $request->file('image') ? $request->file('image')->store('subjects', 'public') : null,
            'slug' => $request->input('slug'),
        ]);

        return redirect()->route('admin.subject.index')->with('success', 'Môn học đã được thêm thành công.');
    }


    public function show($id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.subject.show', compact('subject'));
    }


    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.subject.edit', compact('subject'));
    }


    public function update(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'slug' => 'required|string|max:255|unique:subjects,slug,' . $id,
        ], [
            'name.required' => 'Tên môn học là bắt buộc.',
            'name.string' => 'Tên môn học phải là chuỗi ký tự.',
            'name.max' => 'Tên môn học không được vượt quá 255 ký tự.',
            'image.image' => 'Hình ảnh phải là một tệp hình ảnh.',
            'image.mimes' => 'Hình ảnh chỉ được phép có các định dạng: jpeg, png, jpg, gif, svg.',
            'slug.required' => 'Đường dẫn là bắt buộc.',
            'slug.string' => 'Đường dẫn phải là chuỗi ký tự.',
            'slug.max' => 'Đường dẫn không được vượt quá 255 ký tự.',
            'slug.unique' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác.',
        ]);        

        // Cập nhật môn học
        $subject = Subject::findOrFail($id);
        $subject->update([
            'name' => $request->input('name'),
            'image' => $request->file('image') ? $request->file('image')->store('subjects', 'public') : $subject->image,
            'slug' => $request->input('slug'),
        ]);

        return redirect()->route('admin.subject.index')->with('success', 'Môn học đã được cập nhật thành công.');
    }


    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        if ($subject->image) {
            \Storage::delete($subject->image); // Xóa hình ảnh nếu có
        }
        $subject->delete();

        return redirect()->route('admin.subject.index')->with('success', 'Môn học đã được xóa thành công.');
    }
}
