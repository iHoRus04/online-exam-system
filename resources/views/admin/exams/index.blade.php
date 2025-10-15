<x-app-layout>
   
        <h2 class="font-semibold text-2xl text-gray-800 flex items-center justify-center gap-2">
            📘 <span class="text-blue-600">Danh sách bài thi</span>
        </h2>
  

    <div class="py-10 max-w-6xl mx-auto px-6">
        {{-- Nút thêm bài thi --}}
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('admin.exams.create') }}" 
               class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow">
                ➕ Thêm bài thi
            </a>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-lg shadow-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif
             <div class="mt-8 text-center">
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    ⬅ Quay lại trang Dashboard
                </a>
            </div>
        </div>
        

        {{-- Kiểm tra có dữ liệu hay không --}}
        @if($exams->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg text-center shadow">
                ⚠️ Hiện chưa có bài thi nào được tạo.
            </div>
        @else
            <div class="overflow-x-auto bg-white shadow-md rounded-xl border border-gray-200">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gray-100 uppercase text-xs font-semibold text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">Tiêu đề</th>
                            <th class="px-4 py-3 text-center">⏱️ Thời lượng</th>
                            <th class="px-4 py-3 text-center">❓ Số câu hỏi</th>
                            <th class="px-4 py-3 text-center">⚙️ Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($exams as $exam)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-medium text-gray-600">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    <span class="font-semibold text-gray-800">{{ $exam->title }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $exam->duration }} phút
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $exam->total_questions }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('admin.exams.questions.index', $exam->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 font-semibold">Quản lý</a>
                                        <a href="{{ route('admin.exams.edit', $exam) }}" 
                                           class="text-yellow-500 hover:text-yellow-700 font-semibold">Sửa</a>
                                        <form action="{{ route('admin.exams.destroy', $exam) }}" 
                                              method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bài thi này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-500 hover:text-red-700 font-semibold">
                                                Xóa
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
    </div>
</x-app-layout>
