<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8 flex items-center justify-center gap-3">
                ✏️ <span class="text-blue-600">Chỉnh sửa bài thi: {{ $exam->title }}</span>
            </h2>

            {{-- Hiển thị lỗi chung --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 px-5 py-4 rounded-xl mb-6 shadow-sm">
                    <strong>Lỗi!</strong> Vui lòng kiểm tra lại các trường:
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.exams.update', $exam) }}" method="POST" class="bg-white p-8 rounded-3xl shadow-2xl border border-blue-100 space-y-6">
                @csrf
                @method('PUT')

                {{-- Tiêu đề --}}
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20l9-5-9-5-9 5 9 5z" />
                        </svg>
                        Tiêu đề <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        value="{{ old('title', $exam->title) }}" 
                        placeholder="Nhập tiêu đề bài thi"
                        class="w-full border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm @error('title') border-red-500 @enderror"
                        required
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Thời lượng --}}
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                        ⏱ Thời lượng (phút) <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="duration" 
                        value="{{ old('duration', $exam->duration) }}" 
                        min="1" step="1"
                        placeholder="VD: 60"
                        class="w-full border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm @error('duration') border-red-500 @enderror"
                        required
                    >
                    @error('duration')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tổng số câu hỏi --}}
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                        ❓ Tổng số câu hỏi <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="total_questions" 
                        value="{{ old('total_questions', $exam->total_questions) }}" 
                        min="1" step="1"
                        placeholder="VD: 20"
                        class="w-full border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm @error('total_questions') border-red-500 @enderror"
                        required
                    >
                    @error('total_questions')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nút hành động --}}
                <div class="flex flex-col sm:flex-row gap-4 mt-6 justify-center">
                    <button type="submit" class="flex items-center justify-center gap-2 bg-blue-500 text-white px-6 py-3 rounded-xl hover:bg-blue-600 transition shadow-lg font-medium text-lg">
                        💾 Cập nhật
                    </button>
                    <a href="{{ route('admin.exams.index') }}" class="flex items-center justify-center gap-2 bg-gray-200 text-gray-800 px-6 py-3 rounded-xl hover:bg-gray-300 transition shadow-lg font-medium text-lg">
                        ⬅ Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
