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
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-green-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>

        <button @click="show = false" class="text-green-500 hover:text-green-700 transition" title="Đóng">
            ✕
        </button>
    </div>
    @endif

    <h2 class="font-semibold text-2xl text-gray-800 flex items-center justify-center gap-2 mb-8">
        📘 <span class="text-blue-600">Danh sách bài thi</span>
    </h2>

    <div class="py-10 max-w-6xl mx-auto px-6 space-y-6">
        {{-- Nút thêm bài thi --}}
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.exams.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow">
                ➕ Thêm bài thi
            </a>

            <a href="{{ route('admin.dashboard') }}" class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                ⬅ Quay lại trang Dashboard
            </a>
        </div>

        {{-- Kiểm tra dữ liệu --}}
        @if($exams->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg text-center shadow">
                ⚠️ Hiện chưa có bài thi nào được tạo.
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($exams as $exam)
                    <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg border border-gray-200 transition">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $exam->title }}</h3>
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                ⏱ {{ $exam->duration }} phút
                            </span>
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                ❓ {{ $exam->total_questions }} câu
                            </span>
                        </div>
                        <div class="flex items-center justify-between mt-2 gap-2">
                            <a href="{{ route('admin.exams.questions.index', $exam->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Quản lý</a>
                            <a href="{{ route('admin.exams.edit', $exam) }}" class="text-yellow-500 hover:text-yellow-700 font-semibold">Sửa</a>
                            <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bài thi này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Xóa</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
