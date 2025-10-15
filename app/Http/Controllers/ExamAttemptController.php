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
            $score = 0;

          
            if ($q->type === 'multiple_choice') {
                if ($userAnswer === $q->correct_answer) {
                    $score = 1;
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

       
        $finalScore = round(($correctCount / max($totalQuestions, 1)) * 100, 2);

      
        ExamResult::create([
            'student_id' => $student->id,
            'exam_id' => $exam->id,
            'total_score' => $finalScore,
            'correct_count' => $correctCount,
            'total_questions' => $totalQuestions,
            'submitted_at' => now(),
        ]);

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
