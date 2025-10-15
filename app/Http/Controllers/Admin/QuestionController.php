<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Exam $exam)
    {
        $questions = $exam->questions;
        $currentCount = $questions->count(); // số câu hiện có
        $maxCount = $exam->total_questions; // số câu tối đa

        return view('admin.questions.index', compact('exam', 'questions', 'currentCount', 'maxCount'));
    }


    public function create(Exam $exam)
    {
        return view('admin.questions.create', compact('exam'));
    }

   public function store(Request $request, Exam $exam)
    {
        // 🔒 Kiểm tra giới hạn câu hỏi
        $currentCount = $exam->questions()->count();
        if ($currentCount >= $exam->total_questions) {
            return redirect()
                ->route('admin.exams.questions.index', $exam)
                ->with('error', 'Bài thi này đã đạt số lượng câu hỏi tối đa.');
        }

        // ✅ Validate dữ liệu
        $data = $request->validate([
            'type' => 'required|in:multiple_choice,essay',
            'question_text' => 'required|string',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|string',
        ]);

        $data['exam_id'] = $exam->id;

        if ($data['type'] === 'multiple_choice') {
            // loại bỏ các lựa chọn trống
            $options = array_filter($request->input('options', []), fn($opt) => !empty($opt));

            // lưu lại thành JSON chuẩn
            $data['options'] = json_encode(array_values($options));
        } else {
            // nếu là tự luận → không cần options
            $data['options'] = null;
            $data['correct_answer'] = null;
        }


        Question::create($data);

        return redirect()
            ->route('admin.exams.questions.index', $exam)
            ->with('success', 'Thêm câu hỏi thành công!');
    }


    public function edit(Exam $exam, Question $question)
    {
        return view('admin.questions.edit', compact('exam', 'question'));
    }

    public function update(Request $request, Exam $exam, Question $question)
    {
        $data = $request->validate([
            'type' => 'required|in:multiple_choice,essay',
            'question_text' => 'required|string',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|string',
        ]);

        if ($data['type'] === 'multiple_choice') {
        // loại bỏ các lựa chọn trống
        $options = array_filter($request->input('options', []), fn($opt) => !empty($opt));

        // lưu lại thành JSON chuẩn
        $data['options'] = json_encode(array_values($options));
        } else {
            // nếu là tự luận → không cần options
            $data['options'] = null;
            $data['correct_answer'] = null;
        }


        $question->update($data);

        return redirect()->route('admin.exams.questions.index', $exam)
            ->with('success', 'Cập nhật câu hỏi thành công!');
    }

    public function destroy(Exam $exam, Question $question)
    {
        $question->delete();

        return redirect()->route('admin.exams.questions.index', $exam)
            ->with('success', 'Xóa câu hỏi thành công!');
    }
}
