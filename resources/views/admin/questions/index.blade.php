<x-app-layout>
    {{-- Thông báo thành công --}}
    @if(session('success'))
        <div class="mb-6 p-3 bg-green-100 border border-green-300 text-green-700 rounded-lg text-center font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="max-w-6xl mx-auto bg-white p-8 rounded-2xl shadow-lg mt-10 border border-gray-100">
        
        {{-- Tiêu đề + nút thêm --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-3">
            <h2 class="text-2xl font-bold text-gray-800">
                📝 Câu hỏi của bài thi: 
                <span class="text-blue-600">{{ $exam->title }}</span>
                <span class="ml-1 text-sm text-green-600 font-medium">
                    ({{ $currentCount }}/{{ $maxCount }} câu)
                </span>
            </h2>
            

            @if ($currentCount < $maxCount)
                <a href="{{ route('admin.exams.questions.create', $exam->id) }}" 
                   class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    ➕ Thêm câu hỏi
                </a>
            @else
                <button disabled 
                        class="inline-flex items-center gap-2 bg-gray-400 text-white px-4 py-2 rounded-lg shadow cursor-not-allowed">
                    ✅ Đã đủ câu hỏi
                </button>
            @endif
            
        </div>

        {{-- Nếu chưa có câu hỏi --}}
        @if($questions->isEmpty())
            <div class="p-5 bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-lg text-center font-medium">
                ⚠️ Chưa có câu hỏi nào cho bài thi này.
            </div>
        @else
            {{-- Bảng câu hỏi --}}
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-gray-800 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-center w-12">#</th>
                            <th class="px-4 py-3">Nội dung câu hỏi</th>
                            <th class="px-4 py-3 text-center">Loại</th>
                            <th class="px-4 py-3 text-center">Đáp án đúng</th>
                            <th class="px-4 py-3 text-center w-40">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($questions as $q)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-center font-medium text-gray-600">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    <div class="text-gray-800 font-medium">{{ Str::limit($q->question_text, 80) }}</div>
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
                                           class="px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md text-sm transition shadow">
                                           ✏️ Sửa
                                        </a>
                                        <form action="{{ route('admin.exams.questions.destroy', [$exam, $q]) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm transition shadow">
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
                   class="inline-block bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 transition">
                    ⬅ Quay lại trang Dashboard
                </a>
            </div>
    </div>
</x-app-layout>
