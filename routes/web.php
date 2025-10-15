<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentExamController;
use App\Http\Controllers\ExamAttemptController;
use App\Http\Controllers\Admin\ExamController as AdminExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ExamResultController;
use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('student.exams.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // 📘 Route dành cho user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/exams', [StudentExamController::class, 'index'])->name('student.exams.index');
    Route::get('/exams/{id}', [ExamAttemptController::class, 'show'])->name('exams.take');
    Route::post('/exams/{id}/submit', [ExamAttemptController::class, 'submit'])->name('exams.submit');

    Route::get('/exams/{id}/result', [ExamAttemptController::class, 'result'])->name('exams.result');

});

// ⚙️ Route dành riêng cho admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
     Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
    Route::resource('exams', AdminExamController::class);
    Route::resource('exams.questions', QuestionController::class);
    Route::get('results', [ExamResultController::class, 'index'])->name('results.index');
    Route::get('results/{id}', [ExamResultController::class, 'show'])->name('results.show');
    Route::put('results/score/{id}', [ExamResultController::class, 'updateScore'])->name('results.updateScore');

    
});

require __DIR__.'/auth.php';
