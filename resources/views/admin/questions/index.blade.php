<x-app-layout>
    @if(session('success'))
        <div 
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 5000)"
            x-show="show"
            x-transition
            class="mb-6 flex items-center justify-between bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-3 shadow-sm"
        >
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     fill="none" viewBox="0 0 24 24" stroke-width="2" 
                     stroke="currentColor" class="w-5 h-5 text-green-600">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>

            <button 
                @click="show = false"
                class="text-green-500 hover:text-green-700 transition"
                title="Đóng"
            >
                ✕
            </button>
        </div>
    @endif

    <div class="max-w-6xl mx-auto bg-white p-8 rounded-3xl shadow-2xl mt-10 border border-gray-100">
        
        {{-- Tiêu đề + nút thêm --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-3">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                📝 Câu hỏi bài thi: 
                <span class="text-blue-600">{{ $exam->title }}</span>
                <span class="ml-1 text-sm text-green-600 font-medium">
                    ({{ $currentCount }}/{{ $maxCount }} câu)
                </span>
            </h2>
            
            @if ($currentCount < $maxCount)
                <a href="{{ route('admin.exams.questions.create', $exam->id) }}" 
                   class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-xl shadow hover:bg-blue-700 transition">
                    ➕ Thêm câu hỏi
                </a>
            @else
                <button disabled 
                        class="inline-flex items-center gap-2 bg-gray-400 text-white px-5 py-2 rounded-xl shadow cursor-not-allowed">
                    ✅ Đã đủ câu hỏi
                </button>
            @endif
        </div>

        {{-- Nếu chưa có câu hỏi --}}
        @if($questions->isEmpty())
            <div class="p-6 bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-xl text-center font-medium shadow">
                ⚠️ Chưa có câu hỏi nào cho bài thi này.
            </div>
        @else
            {{-- Bảng câu hỏi --}}
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-gray-800 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-center w-12">#</th>
                            <th class="px-4 py-3">Nội dung câu hỏi</th>
                            <th class="px-4 py-3 text-center">Loại</th>
                            <th class="px-4 py-3 text-center">Đáp án đúng</th>
                            <th class="px-4 py-3 text-center w-44">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($questions as $q)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-center font-medium text-gray-600">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    <div class="text-gray-800 font-medium">{{ Str::limit($q->question_text, 100) }}</div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 text-xs rounded-full font-semibold
                                        {{ $q->type === 'multiple_choice'
                                            ? 'bg-indigo-100 text-indigo-700'
                                            : 'bg-amber-100 text-amber-700' }}">
                                        {{ $q->type === 'multiple_choice' ? 'Trắc nghiệm' : 'Tự luận' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600">
                                    {{ $q->correct_answer ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.exams.questions.edit', [$exam, $q]) }}"
                                           class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-sm font-medium shadow transition">
                                           ✏️ Sửa
                                        </a>
                                        <form action="{{ route('admin.exams.questions.destroy', [$exam, $q]) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium shadow transition">
                                                🗑️ Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        {{-- Nút quay lại --}}
        <div class="mt-8 text-center">
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-block bg-gray-200 text-gray-800 px-6 py-2 rounded-xl hover:bg-gray-300 transition shadow">
                ⬅ Quay lại Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
