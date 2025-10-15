<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExamResultMail;

class ExamResultController extends Controller
{
    // 📋 Danh sách kết quả (filter theo exam, student)
    public function index(Request $request)
    {
        $examId = $request->input('exam_id');
        $studentId = $request->input('student_id');

        $query = ExamResult::with(['student', 'exam'])
            ->when($examId, fn($q) => $q->where('exam_id', $examId))
            ->when($studentId, fn($q) => $q->where('student_id', $studentId));

        $results = $query->orderBy('submitted_at', 'desc')->paginate(10);

        $exams = Exam::all();

        return view('admin.results.index', compact('results', 'exams', 'examId', 'studentId'));
    }

    // 👁️ Xem chi tiết từng bài thi
    public function show($id)
    {
        $result = ExamResult::with(['student', 'exam', 'exam.questions'])->findOrFail($id);

        $answers = StudentAnswer::where('exam_id', $result->exam_id)
            ->where('student_id', $result->student_id)
            ->get()
            ->keyBy('question_id');

        return view('admin.results.show', compact('result', 'answers'));
    }

   // 🧮 Cập nhật điểm thủ công (cho phần tự luận)
    public function updateScore(Request $request, $id)
    {
        $answer = StudentAnswer::findOrFail($id);

        $request->validate([
            'score' => 'required|numeric|min:0|max:10',
        ]);

        $answer->score = $request->score;
        $answer->save();

        // Tính lại tổng điểm
        $total = StudentAnswer::where('student_id', $answer->student_id)
            ->where('exam_id', $answer->exam_id)
            ->sum('score');

        $count = StudentAnswer::where('student_id', $answer->student_id)
            ->where('exam_id', $answer->exam_id)
            ->count();

        $final = round(($total / max($count, 1)) * 100, 2);

        $result = ExamResult::updateOrCreate(
            ['student_id' => $answer->student_id, 'exam_id' => $answer->exam_id],
            ['total_score' => $final]
        );

        // ✅ Gửi email thông báo
        Mail::to($answer->student->email)->send(new ExamResultMail($result));

        return back()->with('success', '✅ Cập nhật điểm và gửi email thông báo thành công!');
    }

}
