<x-app-layout>
     @if(session('success'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 5000)"
            x-transition
            class="max-w-4xl mx-auto mt-4 px-4"
        >
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg shadow-sm flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button type="button" @click="show = false" class="text-green-700 hover:text-green-900 font-bold">✖</button>
            </div>
        </div>
    @endif

    <div class="max-w-5xl mx-auto mt-8 px-4">
        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
            📘 Kết quả bài thi:
            <span class="text-blue-600">{{ $result->exam->title }}</span>
        </h2>

        {{-- Thông tin sinh viên --}}
        <div class="bg-white border rounded-xl p-5 shadow-sm mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-gray-700">
                <p><span class="font-semibold">👨‍🎓 Sinh viên:</span> {{ $result->student->name }}</p>
                <p><span class="font-semibold">📧 Email:</span> {{ $result->student->email }}</p>
                <p>
                    <span class="font-semibold">🎯 Điểm tổng:</span>
                    <span class="text-green-600 font-bold">{{ $result->total_score }} / 100</span>
                </p>
                <p>
                    <span class="font-semibold">⏰ Thời gian nộp:</span>
                    {{ \Carbon\Carbon::parse($result->submitted_at)->format('d/m/Y H:i') ?? 'N/A' }}
                </p>
            </div>
        </div>

        {{-- Danh sách câu hỏi --}}
        @foreach($result->exam->questions as $q)
            @php $ans = $answers[$q->id] ?? null; @endphp

            <div class="bg-white border rounded-xl p-5 shadow-md mb-6">
                <h3 class="text-lg font-semibold mb-3 text-gray-800">
                    Câu {{ $loop->iteration }}: {{ $q->question_text }}
                </h3>

                {{-- Trắc nghiệm --}}
                @if($q->type === 'multiple_choice')
                    <ul class="space-y-2 mb-4">
                        @foreach(json_decode($q->options ?? '[]', true) as $key => $opt)
                            @php
                                $label = chr(65 + $key);
                                $isCorrect = $q->correct_answer == $label;
                                $isStudentChoice = $ans?->answer_text == $label;
                            @endphp
                            <li class="p-3 rounded-lg border transition
                                {{ $isCorrect ? 'bg-green-100 border-green-400' : '' }}
                                {{ $isStudentChoice && !$isCorrect ? 'bg-red-100 border-red-400' : 'border-gray-200' }}">
                                <span class="font-semibold">{{ $label }}.</span> {{ $opt }}
                            </li>
                        @endforeach
                    </ul>

                    <div class="text-gray-700 space-y-1">
                        <p><span class="font-semibold">Đáp án của sinh viên:</span>
                            <span class="text-blue-600 font-medium">{{ strtoupper($ans->answer_text ?? '—') }}</span>
                        </p>
                        <p><span class="font-semibold">Đáp án đúng:</span>
                            <span class="text-green-600 font-medium">{{ strtoupper($q->correct_answer) }}</span>
                        </p>
                        <p><span class="font-semibold">Điểm:</span>
                            <span class="font-bold">{{ number_format($ans->score ?? 0, 2) }}</span>
                        </p>
                    </div>

                {{-- Tự luận --}}
                @elseif($q->type === 'essay')
                    <div class="mb-3">
                        <p class="font-semibold text-gray-700">Bài làm của sinh viên:</p>
                        <div class="border rounded-lg bg-gray-50 p-3 mt-1 text-gray-800 min-h-[60px]">
                            {{ $ans->answer_text ?? '—' }}
                        </div>
                    </div>

                    <form action="{{ route('admin.results.updateScore', $ans->id) }}" method="POST" class="flex flex-wrap items-center gap-3">
                        @csrf
                        @method('PUT')
                        <input
                            type="number"
                            step="0.5"
                            min="0"
                            max="10"
                            name="score"
                            value="{{ $ans->score ?? 0 }}"
                            class="w-24 border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                            required
                        >
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-1.5 rounded-lg hover:bg-blue-700 transition flex items-center gap-1">
                            💾 <span>Lưu điểm</span>
                        </button>
                    </form>
                @endif
            </div>
        @endforeach

        {{-- Nút quay lại --}}
        <div class="text-center mt-8">
            <a href="{{ route('admin.results.index') }}"
               class="inline-flex items-center gap-1 bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                ⬅️ Quay lại danh sách
            </a>
        </div>
    </div>
</x-app-layout>
