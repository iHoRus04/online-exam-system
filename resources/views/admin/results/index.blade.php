<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 px-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h2 class="text-3xl  text-gray-800 flex items-center gap-2">
                📊 <span class="text-blue-600">Danh sách kết quả thi</span>
            </h2>
            <a href="{{ route('admin.dashboard') }}" 
               class="mt-4 md:mt-0 bg-gray-200 text-gray-800 px-5 py-2 rounded-lg font-medium hover:bg-gray-300 transition">
               ⬅ Quay lại Dashboard
            </a>
        </div>

        {{-- Bộ lọc tìm kiếm --}}
        <form method="GET" 
              class="flex flex-wrap items-end gap-4 mb-8 bg-white p-5 border border-gray-200 rounded-xl shadow-sm">
            
            <div class="flex flex-col">
                <label class="text-sm text-gray-600 font-medium mb-1">Chọn bài thi</label>
                <select name="exam_id"
                        class="border-gray-300 rounded-lg text-gray-700 focus:ring-blue-300 focus:border-blue-400">
                    <option value="">-- Tất cả bài thi --</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}" {{ $examId == $exam->id ? 'selected' : '' }}>
                            {{ $exam->title }}
                        </option>
                    @endforeach
                </select>
                
                
            </div>

            <div class="flex flex-col">
                <label class="text-sm text-gray-600 font-medium mb-1">ID sinh viên</label>
                <input type="text"
                       name="student_id"
                       placeholder="Nhập ID..."
                       value="{{ $studentId }}"
                       class="border-gray-300 rounded-lg text-gray-700 focus:ring-blue-300 focus:border-blue-400"
                >
            </div>
            
            <div class="flex flex-col">
                <label class="text-sm text-gray-600 font-medium mb-1">Trạng thái chấm</label>
                <select name="status"
                        class="border-gray-300 rounded-lg text-gray-700 focus:ring-blue-300 focus:border-blue-400">
                    <option value="">-- Tất cả --</option>
                    <option value="graded" {{ request('status') == 'graded' ? 'selected' : '' }}>Đã chấm</option>
                    <option value="ungraded" {{ request('status') == 'ungraded' ? 'selected' : '' }}>Chưa chấm</option>
                </select>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                🔍 Lọc kết quả
            </button>
        </form>

        {{-- Bảng kết quả --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-md overflow-hidden">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-gray-800 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center w-12">#</th>
                        <th class="px-4 py-3 text-left">Sinh viên</th>
                        <th class="px-4 py-3 text-left">Bài thi</th>
                        <th class="px-4 py-3 text-center">Điểm</th>
                        <th class="px-4 py-3 text-center">Ngày nộp</th>
                        <th class="px-4 py-3 text-center">Trạng thái</th>
                        <th class="px-4 py-3 text-center w-32">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($results as $r)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-center font-medium text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $r->student->name }}</td>
                            <td class="px-4 py-3">{{ $r->exam->title }}</td>
                            <td class="px-4 py-3 text-center font-bold text-blue-600">
                                {{ $r->total_score ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-center text-gray-500">
                                {{ \Carbon\Carbon::parse($r->submitted_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($r->has_ungraded)
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium">
                                        ⏳ Chưa chấm hết
                                    </span>
                                @else
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">
                                        ✅ Đã chấm xong
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin.results.show', $r->id) }}"
                                   class="inline-flex items-center gap-1 bg-indigo-500 text-white px-3 py-1.5 rounded-md text-xs hover:bg-indigo-600 transition">
                                    👁️ Xem
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                ⚠️ Không có kết quả nào được tìm thấy.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Phân trang --}}
        <div class="mt-6 flex justify-center">
            {{ $results->links('pagination::tailwind') }}
        </div>
    </div>
</x-app-layout>
