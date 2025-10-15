<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📊 Kết quả bài thi: {{ $exam->title }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-lg font-semibold mb-2">Tổng kết</h3>
            <p><strong>Điểm:</strong> {{ $result->total_score }} / 100</p>
            <p><strong>Số câu đúng:</strong> {{ $result->correct_count }} / {{ $result->total_questions }}</p>
            <p><strong>Thời gian nộp bài:</strong> {{ $result->submitted_at->format('H:i:s d/m/Y') }}</p>
        </div>

        <div class="space-y-4">
            @foreach($exam->questions as $index => $q)
                @php
                    $answer = $answers[$q->id]->answer_text ?? null;
                    $isCorrect = $q->type === 'multiple_choice' && $answer === $q->correct_answer;
                @endphp

                <div class="bg-white p-4 rounded shadow">
                    <p class="font-semibold">
                        {{ $index + 1 }}. {{ $q->question_text }}
                    </p>

                    @if($q->type === 'multiple_choice')
                        <ul class="mt-2">
                            @foreach(json_decode($q->options, true) as $key => $opt)
                                <li class="mt-1">
                                    <span class="
                                        @if($key === $q->correct_answer) text-green-600 font-semibold
                                        @elseif($key === $answer && $key !== $q->correct_answer) text-red-600 font-semibold
                                        @endif
                                    ">
                                        {{ $key }}. {{ $opt }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                        <p class="mt-2">
                            🧠 <strong>Đáp án của bạn:</strong> 
                            <span class="{{ $isCorrect ? 'text-green-600' : 'text-red-600' }}">
                                {{ $answer ?? 'Chưa chọn' }}
                            </span>
                        </p>
                    @else
                        <p class="mt-2">📝 Câu tự luận: {{ $answer ?? 'Chưa trả lời' }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('student.exams.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                ⬅️ Quay lại danh sách bài thi
            </a>
        </div>
    </div>
</x-app-layout>
