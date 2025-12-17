<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class StudentExamController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->input('search');
    $status = $request->input('status');
    $studentId = auth()->id();

    $exams = \App\Models\Exam::query()
        ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
        ->get()
        // Lọc trạng thái trên collection sau khi truy vấn DB. Lưu ý:
        // - `search` được áp dụng trên query để tận dụng index DB.
        // - `status` (done/not_done) được tính bằng cách kiểm tra existence
        //   của ExamResult cho từng exam; hiện tại lọc này được thực hiện
        //   trên collection (in-memory). Có thể cải tiến bằng cách join/whereExists
        //   để lọc trực tiếp trong DB nếu cần hiệu năng/phan trang.
        ->filter(function($exam) use ($status, $studentId) {
            $hasResult = \App\Models\ExamResult::where('exam_id', $exam->id)
                            ->where('student_id', $studentId)
                            ->exists();

            if ($status == 'done') return $hasResult;
            if ($status == 'not_done') return !$hasResult;
            return true;
        });

    return view('exams.index', compact('exams'));
    }

}