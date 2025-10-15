<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-8 bg-white shadow-lg rounded-xl mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            ➕ Thêm câu hỏi mới cho bài thi:
            <span class="text-indigo-600">{{ $exam->title }}</span>
        </h2>

        {{-- Hiển thị lỗi --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.exams.questions.store', $exam) }}" class="space-y-5">
            @csrf

            {{-- Loại câu hỏi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Loại câu hỏi</label>
                <select name="type" id="questionType"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="multiple_choice">Trắc nghiệm</option>
                    <option value="essay">Tự luận</option>
                </select>
            </div>

            {{-- Nội dung câu hỏi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nội dung câu hỏi</label>
                <textarea name="question_text"
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                          rows="3" required></textarea>
            </div>

            {{-- Các lựa chọn cho trắc nghiệm --}}
            <div id="multipleChoiceFields">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Các lựa chọn (A, B, C, D)</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @for ($i = 0; $i < 4; $i++)
                            <input type="text"
                                   name="options[]"
                                   placeholder="Lựa chọn {{ chr(65+$i) }}"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @endfor
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 mt-4">Đáp án đúng</label>
                    <select name="correct_answer"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Chọn đáp án đúng --</option>
                        @foreach(['A','B','C','D'] as $opt)
                            <option value="{{ $opt }}">{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Nút hành động --}}
            <div class="flex items-center justify-between pt-4">
                <a href="{{ route('admin.exams.questions.index', $exam) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition">
                    ⬅ Quay lại
                </a>

                <button type="submit"
                        class="inline-flex items-center px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow transition">
                    💾 Lưu câu hỏi
                </button>
            </div>
        </form>
    </div>

    
    <script>
        const typeSelect = document.getElementById('questionType');
        const mcFields = document.getElementById('multipleChoiceFields');
        typeSelect.addEventListener('change', () => {
            mcFields.classList.toggle('hidden', typeSelect.value === 'essay');
        });
    </script>
</x-app-layout>
