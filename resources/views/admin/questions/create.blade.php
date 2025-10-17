<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-8 bg-white shadow-xl rounded-2xl mt-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
            ➕ Thêm câu hỏi mới cho bài thi: 
            <span class="text-indigo-600">{{ $exam->title }}</span>
        </h2>

        {{-- Hiển thị lỗi --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-300 text-red-700 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.exams.questions.store', $exam) }}" x-data="{ type: 'multiple_choice' }" class="space-y-6">
            @csrf

            {{-- Loại câu hỏi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Loại câu hỏi</label>
                <select name="type" x-model="type"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    <option value="multiple_choice">Trắc nghiệm</option>
                    <option value="essay">Tự luận</option>
                </select>
            </div>

            {{-- Nội dung câu hỏi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nội dung câu hỏi</label>
                <textarea name="question_text" rows="4" required
                          class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
            </div>

            {{-- Khu vực Trắc nghiệm --}}
            <div x-show="type === 'multiple_choice'" x-transition class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Các lựa chọn (A, B, C, D)</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @for ($i = 0; $i < 4; $i++)
                            <input type="text" name="options[]" placeholder="Lựa chọn {{ chr(65+$i) }}"
                                   class="w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @endfor
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Đáp án đúng</label>
                    <select name="correct_answer"
                            class="w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="">-- Chọn đáp án đúng --</option>
                        @foreach(['A','B','C','D'] as $opt)
                            <option value="{{ $opt }}">{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Nút hành động --}}
            <div class="flex flex-wrap gap-3 justify-between pt-4">
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
</x-app-layout>
