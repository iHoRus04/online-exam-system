<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamAttemptController extends Controller
{
    public function show($id)
    {
        $exam = Exam::with('questions')->findOrFail($id);
        return view('exams.take', compact('exam'));
    }

    public function submit(Request $request, $id)
    {
        $exam = Exam::with('questions')->findOrFail($id);
        $student = auth()->user();

        $answers = $request->input('answers', []);
        $correctCount = 0;
        $totalQuestions = $exam->questions->count();

        foreach ($exam->questions as $q) {
            $userAnswer = $answers[$q->id] ?? null;
            $score = null;

            // Xử lý từng câu hỏi: hiện tại chỉ tự chấm trắc nghiệm.
            if ($q->type === 'multiple_choice') {
                // Với trắc nghiệm, so sánh trực tiếp với `correct_answer`.
                if ($userAnswer === $q->correct_answer) {
                    $score = 1; // dùng 1 để đánh dấu đúng (tính phần trăm sau)
                    $correctCount++;
                }
            }

            
            StudentAnswer::create([
                'student_id' => $student->id,
                'exam_id' => $exam->id,
                'question_id' => $q->id,
                'answer_text' => $userAnswer,
                'score' => $score,
                'submitted_at' => now(),
            ]);
        }

       
        $totalScored = StudentAnswer::where('exam_id', $exam->id)
            ->where('student_id', $student->id)
            ->whereNotNull('score')
            ->sum('score');

        $gradedQuestions = StudentAnswer::where('exam_id', $exam->id)
            ->where('student_id', $student->id)
            ->whereNotNull('score')
            ->count();

        $totalQuestions = $exam->questions->count();

        // Điểm hiện tại (chỉ tính câu trắc nghiệm)
        $finalScore = round(($totalScored / max($totalQuestions, 1)) * 100, 2);

        ExamResult::updateOrCreate(
            ['student_id' => $student->id, 'exam_id' => $exam->id],
            [
                'total_score' => $finalScore,
                'correct_count' => $gradedQuestions,
                'total_questions' => $totalQuestions,
                'submitted_at' => now(),
            ]
        );

        return redirect()->route('student.exams.index')
            ->with('success', "📝 Nộp bài thành công!");
    }
    public function result($exam_id)
    {
        $student = auth()->user();

        $exam = \App\Models\Exam::with('questions')->findOrFail($exam_id);

        $answers = \App\Models\StudentAnswer::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->get()
            ->keyBy('question_id');

        $result = \App\Models\ExamResult::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->latest()
            ->first();

        return view('exams.result', compact('exam', 'answers', 'result'));
    }

}
