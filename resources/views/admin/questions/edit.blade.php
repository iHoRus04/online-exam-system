<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
            ✏️ Sửa câu hỏi
        </h2>

        <form method="POST" 
              action="{{ route('admin.exams.questions.update', [$exam, $question]) }}"
              x-data="{ type: '{{ $question->type }}' }"
              class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Loại câu hỏi --}}
            <div>
                <label class="block font-semibold text-gray-700 mb-2">Loại câu hỏi</label>
                <select name="type" x-model="type"
                        class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                    <option value="multiple_choice">Trắc nghiệm</option>
                    <option value="essay">Tự luận</option>
                </select>
            </div>

            {{-- Nội dung câu hỏi --}}
            <div>
                <label class="block font-semibold text-gray-700 mb-2">Nội dung câu hỏi</label>
                <textarea name="question_text" rows="4" required
                          class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">{{ $question->question_text }}</textarea>
            </div>

            {{-- Khu vực trắc nghiệm --}}
            <div x-show="type === 'multiple_choice'" x-transition class="space-y-4">
                @php
                    $options = is_string($question->options)
                        ? json_decode($question->options, true)
                        : ($question->options ?? []);
                    $options = $options ?: [];
                @endphp

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Các lựa chọn</label>
                    @foreach ($options as $index => $opt)
                        <input type="text"
                               name="options[]"
                               value="{{ $opt }}"
                               placeholder="Lựa chọn {{ $loop->iteration }}"
                               class="w-full mb-2 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                    @endforeach
                    
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Đáp án đúng</label>
                    <input type="text"
                           name="correct_answer"
                           value="{{ $question->correct_answer }}"
                           placeholder="Ví dụ: A"
                           class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
                </div>
            </div>

            {{-- Nút hành động --}}
            <div class="flex flex-wrap gap-3 mt-4">
                <button type="submit"
                        class="flex items-center gap-2 bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700 shadow transition">
                    💾 Cập nhật
                </button>
                <a href="{{ route('admin.exams.questions.index', $exam) }}"
                   class="flex items-center gap-2 bg-gray-200 text-gray-800 px-6 py-2 rounded-xl hover:bg-gray-300 shadow transition">
                    ⬅️ Quay lại
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
