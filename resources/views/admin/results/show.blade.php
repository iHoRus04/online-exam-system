<x-app-layout>
    {{-- Thông báo thành công --}}
    @if(session('success'))
        <div 
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 5000)"
            x-show="show"
            x-transition
            class="mb-6 flex items-center justify-between bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-3 shadow-sm"
        >
            <div class="flex items-center gap-2">
                ✅ <span class="font-semibold">{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-700 transition" title="Đóng">✕</button>
        </div>
    @endif

    <div class="max-w-5xl mx-auto mt-8 px-4">
        {{-- Tiêu đề --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h2 class="text-3xl text-gray-800 flex items-center gap-2">
                📘 Kết quả bài thi: 
                <span class="text-blue-600"> {{ $result->exam->title }}</span>
            </h2>
            <a href="{{ route('admin.results.index') }}" 
               class="mt-4 md:mt-0 bg-gray-200 text-gray-800 px-5 py-2 rounded-lg font-medium hover:bg-gray-300 transition">
               ⬅ Quay lại Dashboard
            </a>
        </div>

        {{-- Thông tin sinh viên --}}
        <div class="bg-white border rounded-xl p-5 shadow-sm mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-gray-700">
                <p><span class="font-semibold">👨‍🎓 Sinh viên:</span> {{ $result->student->name }}</p>
                <p><span class="font-semibold">📧 Email:</span> {{ $result->student->email }}</p>
                <p><span class="font-semibold">🎯 Điểm tổng:</span> <span class="text-green-600 font-bold">{{ $result->total_score }} / 100</span></p>
                <p><span class="font-semibold">⏰ Thời gian nộp:</span> {{ \Carbon\Carbon::parse($result->submitted_at)->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        {{-- Form chấm điểm tất cả --}}
        <form action="{{ route('admin.results.updateAllScores', $result->id) }}" method="POST" x-data="{ tab: 'multiple' }">
            @csrf
            @method('PUT')

            {{-- Thanh chuyển tab --}}
            <div class="flex justify-center mb-6 border-b border-gray-200">
                <button type="button" 
                        @click="tab = 'multiple'"
                        :class="tab === 'multiple' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500'"
                        class="px-6 py-2 focus:outline-none">
                    🧩 Câu trắc nghiệm
                </button>

                <button type="button" 
                        @click="tab = 'essay'"
                        :class="tab === 'essay' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500'"
                        class="px-6 py-2 focus:outline-none">
                    📝 Câu tự luận
                </button>
            </div>

            {{-- TAB TRẮC NGHIỆM --}}
            <div x-show="tab === 'multiple'" x-transition>
                @foreach($result->exam->questions->where('type', 'multiple_choice') as $q)
                    @php $ans = $answers[$q->id] ?? null; @endphp

                    <div class="bg-white border rounded-xl p-5 shadow mb-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-800">
                            {{ $loop->iteration }}. {{ $q->question_text }}
                        </h3>

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
                            <p><strong>Đáp án của sinh viên:</strong> 
                                <span class="text-blue-600 font-medium">{{ strtoupper($ans->answer_text ?? '—') }}</span>
                            </p>
                            <p><strong>Đáp án đúng:</strong> 
                                <span class="text-green-600 font-medium">{{ strtoupper($q->correct_answer) }}</span>
                            </p>
                            <p><strong>Điểm:</strong> 
                                <span class="font-bold">{{ number_format($ans->score ?? 0, 2) }}</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- TAB TỰ LUẬN --}}
            <div x-show="tab === 'essay'" x-transition>
                @foreach($result->exam->questions->where('type', 'essay') as $q)
                    @php $ans = $answers[$q->id] ?? null; @endphp

                    <div class="bg-white border rounded-xl p-5 shadow mb-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-800">
                            {{ $loop->iteration }}. {{ $q->question_text }}
                        </h3>

                        <p class="font-semibold text-gray-700">Bài làm của sinh viên:</p>
                        <div class="border rounded-lg bg-gray-50 p-3 mt-1 text-gray-800 min-h-[60px]">
                            {{ $ans->answer_text ?? '—' }}
                        </div>

                        @if($ans)
                            <div class="flex items-center gap-3 mt-3">
                                <input type="hidden" name="answer_id[]" value="{{ $ans->id }}">
                                <label class="font-semibold text-gray-700">Điểm:</label>
                                <input
                                    type="number"
                                    step="0.5"
                                    min="0"
                                    max="10"
                                    name="score[]"
                                    value="{{ $ans->score ?? 0 }}"
                                    class="w-24 border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                    required
                                >
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Nút lưu tất cả --}}
            <div class="text-center mt-10">
                <button type="submit"
                        class="bg-blue-600 text-white px-8 py-2.5 rounded-lg font-medium hover:bg-blue-700 shadow transition">
                    💾 Lưu tất cả điểm
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
