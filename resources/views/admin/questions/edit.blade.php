<x-app-layout>
    <div class="max-w-3xl mx-auto mt-8 bg-white shadow-lg rounded-xl p-6">
        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
            ✏️ Sửa câu hỏi
        </h2>

        <form method="POST" 
              action="{{ route('admin.exams.questions.update', [$exam, $question]) }}"
              x-data="{ type: '{{ $question->type }}' }">
            @csrf
            @method('PUT')

            {{-- Loại câu hỏi --}}
            <div class="mb-5">
                <label class="block font-semibold text-gray-700 mb-2">Loại câu hỏi</label>
                <select name="type" x-model="type"
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-300 focus:border-blue-400">
                    <option value="multiple_choice">Trắc nghiệm</option>
                    <option value="essay">Tự luận</option>
                </select>
            </div>

            {{-- Nội dung câu hỏi --}}
            <div class="mb-5">
                <label class="block font-semibold text-gray-700 mb-2">Nội dung câu hỏi</label>
                <textarea name="question_text" rows="3" required
                          class="w-full border-gray-300 rounded-lg focus:ring-blue-300 focus:border-blue-400">{{ $question->question_text }}</textarea>
            </div>

            {{-- Các lựa chọn cho trắc nghiệm --}}
            <div x-show="type === 'multiple_choice'" x-transition>
                @php
                    $options = is_string($question->options)
                        ? json_decode($question->options, true)
                        : ($question->options ?? []);
                    $options = $options ?: [];
                @endphp

                <div class="mb-3">
                    <label class="block font-semibold text-gray-700 mb-2">Các lựa chọn</label>
                    @foreach ($options as $index => $opt)
                        <input type="text"
                               name="options[]"
                               value="{{ $opt }}"
                               placeholder="Lựa chọn {{ $loop->iteration }}"
                               class="w-full mb-2 border-gray-300 rounded-lg focus:ring-blue-300 focus:border-blue-400">
                    @endforeach
                    {{-- Thêm input trống để dễ thêm lựa chọn mới --}}
                    <input type="text"
                           name="options[]"
                           placeholder="Thêm lựa chọn mới..."
                           class="w-full mb-2 border-gray-300 rounded-lg focus:ring-blue-300 focus:border-blue-400">
                </div>

                <div class="mb-5">
                    <label class="block font-semibold text-gray-700 mb-2">Đáp án đúng</label>
                    <input type="text"
                           name="correct_answer"
                           value="{{ $question->correct_answer }}"
                           placeholder="Ví dụ: A"
                           class="w-full border-gray-300 rounded-lg focus:ring-blue-300 focus:border-blue-400">
                </div>
            </div>

            {{-- Nút hành động --}}
            <div class="flex items-center gap-3 mt-6">
                <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                    💾 Cập nhật
                </button>
                <a href="{{ route('admin.exams.questions.index', $exam) }}"
                   class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 transition">
                    ⬅️ Quay lại
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
