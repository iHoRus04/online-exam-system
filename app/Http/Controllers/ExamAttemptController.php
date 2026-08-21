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
        $scorePerQuestion = 100 / max($totalQuestions, 1);
        $earnedScore = 0;

        foreach ($exam->questions as $q) {
            $userAnswer = $answers[$q->id] ?? null;
            $score = null;

            if ($q->type === 'multiple_choice') {
                if ($userAnswer === $q->correct_answer) {
                    $score = 1;
                    $correctCount++;
                    $earnedScore += $scorePerQuestion;
                } else {
                    $score = 0;
                }
            } else {
                // Tự luận: Giữ lại điểm nếu Admin đã chấm trước đó
                $existing = StudentAnswer::where('student_id', $student->id)
                    ->where('exam_id', $exam->id)
                    ->where('question_id', $q->id)
                    ->first();

                $score = $existing?->score;
                if ($score !== null) {
                    $earnedScore += $score;
                }
            }

            // Dùng updateOrCreate để tránh tạo bản ghi trùng lặp mỗi lần nộp bài
            StudentAnswer::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'exam_id' => $exam->id,
                    'question_id' => $q->id,
                ],
                [
                    'answer_text' => $userAnswer,
                    'score' => $score,
                    'submitted_at' => now(),
                ]
            );
        }

        // Tính tổng điểm (tối đa 100 điểm)
        $finalScore = round(min($earnedScore, 100), 2);

        ExamResult::updateOrCreate(
            ['student_id' => $student->id, 'exam_id' => $exam->id],
            [
                'total_score' => $finalScore,
                'correct_count' => $correctCount,
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
