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
    // 📋 Danh sách kết quả
   public function index(Request $request)
    {
        $examId = $request->input('exam_id');
        $studentId = $request->input('student_id');
        $status = $request->input('status'); // ⬅️ thêm dòng này

        $query = ExamResult::with(['student', 'exam'])
            ->when($examId, fn($q) => $q->where('exam_id', $examId))
            ->when($studentId, fn($q) => $q->where('student_id', $studentId));

       if ($status === 'graded') {
            $query->whereDoesntHave('exam.questions', function ($q) {
                $q->where('type', 'essay')
                ->whereHas('studentAnswers', function ($a) {
                    $a->whereNull('score');
                });
            });
        } elseif ($status === 'ungraded') {
            $query->whereHas('exam.questions', function ($q) {
                $q->where('type', 'essay')
                ->whereHas('studentAnswers', function ($a) {
                    $a->whereNull('score');
                });
            });
        }

        $results = $query->orderBy('submitted_at', 'desc')->paginate(10);

        $results->transform(function ($r) {
            $r->has_ungraded = \App\Models\StudentAnswer::where('exam_id', $r->exam_id)
                ->where('student_id', $r->student_id)
                ->whereHas('question', fn($q) => $q->where('type', 'essay'))
                ->whereNull('score')
                ->exists();
            return $r;
        });

        $exams = Exam::all();

        return view('admin.results.index', compact('results', 'exams', 'examId', 'studentId', 'status'));
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

   
    public function updateAllScores(Request $request, $resultId)
        {
            $request->validate([
                'answer_id' => 'required|array',
                'score' => 'required|array',
            ]);

            foreach ($request->answer_id as $index => $answerId) {
                $answer = \App\Models\StudentAnswer::find($answerId);
                if ($answer) {
                    $answer->score = $request->score[$index];
                    $answer->save();
                }
            }

            // 🧮 Tính lại tổng điểm
            $result = \App\Models\ExamResult::findOrFail($resultId);

            $total = \App\Models\StudentAnswer::where('student_id', $result->student_id)
                ->where('exam_id', $result->exam_id)
                ->sum('score');

            $count = \App\Models\StudentAnswer::where('student_id', $result->student_id)
                ->where('exam_id', $result->exam_id)
                ->count();

            $final = round(($total / max($count, 1)) * 100, 2);
            $result->total_score = $final;
            $result->save();

            return back()->with('success', 'Đã lưu tất cả điểm thành công!');
        }

    
}
