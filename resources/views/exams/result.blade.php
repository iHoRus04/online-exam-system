<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-100 to-purple-50 py-12 px-6">
        <div class="max-w-5xl mx-auto">

            {{-- Header --}}
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold flex items-center justify-center gap-3 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                    📊 Kết quả bài thi: {{ $exam->title }}
                </h2>
                <p class="text-gray-600 mt-3 text-lg">Chi tiết kết quả và đáp án của bạn</p>
            </div>

            {{-- Tổng kết --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
                {{-- Điểm tổng --}}
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-3xl p-6 shadow-2xl flex flex-col items-center justify-center gap-3 transform hover:scale-105 transition-all duration-300">
                    <div class="text-4xl animate-bounce">🧾</div>
                    <p class="text-sm font-semibold tracking-wide">Điểm tổng</p>
                    <p class="text-3xl sm:text-4xl font-extrabold">{{ $result->total_score }} / 100</p>
                </div>

                {{-- Số câu đúng --}}
                @php
                    $mcQuestions = $exam->questions->where('type', 'multiple_choice');
                    $correctCount = 0;
                    foreach ($mcQuestions as $q) {
                        $userAnswer = $answers[$q->id]->answer_text ?? null;
                        if ($userAnswer === $q->correct_answer) $correctCount++;
                    }
                    $essayQuestions = $exam->questions->where('type', 'essay');
                @endphp
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-3xl p-6 shadow-2xl flex flex-col items-center justify-center gap-3 transform hover:scale-105 transition-all duration-300">
                    <div class="text-4xl animate-bounce">✅</div>
                    <p class="text-sm font-semibold tracking-wide">Số câu đúng</p>
                    <p class="text-3xl sm:text-4xl font-extrabold">{{ $correctCount }} / {{ $mcQuestions->count() }}</p>
                </div>

                {{-- Thời gian nộp --}}
                <div class="bg-gradient-to-br from-orange-500 to-pink-600 text-white rounded-3xl p-6 shadow-2xl flex flex-col items-center justify-center gap-3 transform hover:scale-105 transition-all duration-300">
                    <div class="text-4xl animate-bounce">⏱</div>
                    <p class="text-sm font-semibold tracking-wide">Thời gian nộp</p>
                    <p class="text-lg sm:text-xl font-semibold">{{ $result->submitted_at->format('H:i:s d/m/Y') }}</p>
                </div>
            </div>

            {{-- Tabs --}}
            <div x-data="{ activeTab: 'multiple_choice' }" class="mb-8">
                <div class="flex border-b-2 border-gray-200 mb-4">
                    <button @click="activeTab = 'multiple_choice'" 
                        :class="activeTab === 'multiple_choice' ? 'border-purple-600 text-purple-600 font-bold' : 'text-gray-600'"
                        class="px-6 py-2 -mb-2 border-b-4 transition-all duration-300">
                        Trắc nghiệm
                    </button>
                    <button @click="activeTab = 'essay'" 
                        :class="activeTab === 'essay' ? 'border-purple-600 text-purple-600 font-bold' : 'text-gray-600'"
                        class="px-6 py-2 -mb-2 border-b-4 transition-all duration-300">
                        Tự luận
                    </button>
                </div>

                {{-- Câu hỏi Trắc nghiệm --}}
                <div x-show="activeTab === 'multiple_choice'" class="space-y-8">
                    @foreach($mcQuestions as $index => $q)
                        @php
                            $answer = $answers[$q->id]->answer_text ?? null;
                            $score = $answers[$q->id]->score ?? null;
                            $isCorrect = $answer === $q->correct_answer;
                            $borderGradient = $isCorrect ? 'from-green-400 to-emerald-500' : 'from-red-400 to-orange-400';
                        @endphp
                        <div class="relative rounded-3xl shadow-2xl overflow-hidden border-4 border-transparent bg-white hover:shadow-3xl transform hover:scale-[1.02] transition-all duration-300">
                            {{-- Header --}}
                            <div class="p-6 bg-gradient-to-br {{ $borderGradient }} text-white flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="text-2xl sm:text-3xl">{{ $isCorrect ? '✅' : '❌' }}</div>
                                    <div>
                                        <p class="font-semibold text-lg sm:text-xl">Câu {{ $index + 1 }}</p>
                                        <p class="text-sm sm:text-base">Trắc nghiệm</p>
                                    </div>
                                </div>
                                @php
                                    $ans = $answers[$q->id] ?? null;
                                    $totalQuestions = $exam->questions->count();
                                    $pointPerQuestion = 100 / max($totalQuestions, 1);
                                    $isCorrect = $q->type === 'multiple_choice' && ($ans?->answer_text === $q->correct_answer);
                                @endphp

                                <div class="text-sm sm:text-base font-bold bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full shadow-lg">
                                    @if($isCorrect)
                                        +{{ number_format($pointPerQuestion, 0) }} điểm
                                    @else
                                        0 điểm
                                    @endif
                                </div>

                            </div>
                            {{-- Body --}}
                            <div class="p-6 space-y-3">
                                <p class="font-semibold text-gray-800 text-lg sm:text-xl">{{ $q->question_text }}</p>
                                <ul class="space-y-2">
                                    @php $optionsList = is_array($q->options) ? $q->options : (json_decode($q->options ?? '[]', true) ?? []); @endphp
                                    @foreach($optionsList as $key => $opt)
                                        @php
                                            $optLabel = is_numeric($key) ? chr(65 + (int)$key) : strtoupper($key);
                                        @endphp
                                        <li class="px-4 py-2 rounded-lg border flex items-center gap-2
                                            @if((string)$key === (string)$q->correct_answer) border-green-300 bg-green-50 text-green-700 font-semibold
                                            @elseif((string)$key === (string)$answer && (string)$key !== (string)$q->correct_answer) border-red-300 bg-red-50 text-red-700 font-semibold
                                            @else border-gray-200 text-gray-700
                                            @endif hover:scale-[1.02] transition-all duration-200">
                                            <span class="font-bold">{{ $optLabel }}.</span> {{ $opt }}
                                            @if((string)$key === (string)$q->correct_answer) ✅ @elseif((string)$key === (string)$answer && (string)$key !== (string)$q->correct_answer) ❌ @endif
                                        </li>
                                    @endforeach
                                </ul> 
                                <p class="mt-2 text-sm">
                                    <strong>🧠 Đáp án của bạn:</strong>
                                    <span class="{{ $isCorrect ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                                        {{ $answer ?? 'Chưa chọn' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Câu hỏi Tự luận --}}
                <div x-show="activeTab === 'essay'" class="space-y-8">
                    @foreach($essayQuestions as $index => $q)
                        @php
                            $answer = $answers[$q->id]->answer_text ?? null;
                            $score = $answers[$q->id]->score ?? null;
                        @endphp
                        <div class="relative rounded-3xl shadow-2xl overflow-hidden border-4 border-yellow-400 bg-white hover:shadow-3xl transform hover:scale-[1.02] transition-all duration-300">
                            {{-- Header --}}
                            <div class="p-6 bg-gradient-to-br from-yellow-400 to-yellow-200 text-white flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="text-2xl sm:text-3xl">⏳</div>
                                    <div>
                                        <p class="font-semibold text-lg sm:text-xl">Câu {{ $index + 1 }}</p>
                                        <p class="text-sm sm:text-base">Tự luận</p>
                                    </div>
                                </div>
                                <div class="text-sm sm:text-base font-bold bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full shadow-lg">
                                    @if(is_null($score))
                                        Chưa chấm
                                    @else
                                        {{ $score }}/10
                                    @endif
                                </div>
                            </div>
                            {{-- Body --}}
                            <div class="p-6 space-y-3">
                                <p class="font-semibold text-gray-800 text-lg sm:text-xl">{{ $q->question_text }}</p>
                                <p class="mt-2 text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-200 shadow-inner">
                                    📝 <strong>Bài làm:</strong> {{ $answer ?? 'Chưa trả lời' }}
                                </p>
                                <p class="mt-2 text-sm text-gray-600 italic">
                                    @if(is_null($score))
                                        ⏳ Câu này đang chờ chấm điểm.
                                    @else
                                        ✅ Câu này đã được chấm điểm.
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Nút quay lại --}}
            <div class="mt-12 text-center">
                <a href="{{ route('student.exams.index') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-3xl shadow-2xl hover:shadow-3xl hover:scale-105 transform transition-all duration-300 font-semibold">
                    ⬅️ Quay lại danh sách bài thi
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
