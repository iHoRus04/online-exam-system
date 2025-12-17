<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::all();
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        return view('admin.exams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'total_questions' => 'required|integer|min:1',
        ]);

        // Tạo bài thi mới từ request. Các validation ở trên đảm bảo dữ liệu hợp lệ.
        Exam::create($request->all());

        return redirect()->route('admin.exams.index')->with('success', 'Tạo bài thi thành công!');
    }

    public function edit(Exam $exam)
    {
        return view('admin.exams.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'total_questions' => 'required|integer|min:1',
        ]);

        $exam->update($request->all());

        return redirect()->route('admin.exams.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')->with('success', 'Đã xóa bài thi!');
    }
}
