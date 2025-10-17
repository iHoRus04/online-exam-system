<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\User;
use App\Models\ExamResult;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $examCount = Exam::count();
        $studentCount = User::where('is_admin', false)->count();
        $resultCount = ExamResult::count();
        $gradedCount = ExamResult::whereDoesntHave('exam', function ($examQuery) {
        $examQuery->whereHas('questions', function ($q) {
            $q->where('type', 'essay')
              ->whereHas('studentAnswers', function ($a) {
                  $a->whereNull('score');
              });
        });
    })->count();

        return view('admin.dashboard', compact(
            'examCount',
            'studentCount',
            'resultCount',
            'gradedCount'
        ));
    }
}
