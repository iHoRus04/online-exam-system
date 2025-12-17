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

       // Nếu filter theo trạng thái graded/ungraded thì áp dụng điều kiện toán học
       // graded: không tồn tại câu tự luận (essay) chưa được chấm (score IS NULL)
       // ungraded: tồn tại ít nhất một câu tự luận chưa chấm
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

        // Thêm cờ `has_ungraded` để view có thể hiển thị badge/indicator.
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

            // Cập nhật điểm từng câu
            foreach ($request->answer_id as $index => $answerId) {
                $answer = \App\Models\StudentAnswer::find($answerId);
                if ($answer) {
                    $answer->score = $request->score[$index];
                    $answer->save();
                }
            }

            // 🧮 Tính lại tổng điểm
            $result = \App\Models\ExamResult::with(['exam.questions', 'student'])->findOrFail($resultId);

            $totalQuestions = $result->exam->questions->count();
            $scorePerQuestion = 100 / max($totalQuestions, 1);

            $studentAnswers = \App\Models\StudentAnswer::where('student_id', $result->student_id)
                ->where('exam_id', $result->exam_id)
                ->get();

            $earned = 0;

            foreach ($studentAnswers as $ans) {
                // Trắc nghiệm: điểm = 1 nếu đúng
                if ($ans->question->type === 'multiple_choice' && $ans->answer_text === $ans->question->correct_answer) {
                    $earned += $scorePerQuestion ;
                }
                
                elseif ($ans->question->type === 'essay' && $ans->score !== null) {
                    $earned += $ans->score ;
                }
            }

            $result->total_score = round($earned, 2);
            $result->save();

            // Gửi email thông báo kết quả (nếu sinh viên có email)
            try {
                if ($result->student && !empty($result->student->email)) {
                    Mail::to($result->student->email)->send(new ExamResultMail($result));
                    \Log::info('Exam result email sent', ['result_id' => $result->id, 'student_id' => $result->student_id]);
                } else {
                    \Log::warning('Exam result not emailed: student has no email', ['result_id' => $result->id, 'student_id' => $result->student_id]);
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send exam result email', ['result_id' => $result->id, 'error' => $e->getMessage()]);
            }

            return back()->with('success', '✅ Đã lưu và cập nhật tổng điểm chính xác!');
        }


    
}
