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