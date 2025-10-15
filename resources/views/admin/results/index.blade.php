<x-app-layout>
    <div class="max-w-6xl mx-auto mt-8 px-4">
        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
            📊 Kết quả thi
        </h2>

        {{-- Bộ lọc tìm kiếm --}}
        <form method="GET" class="flex flex-wrap gap-3 mb-6 bg-white p-4 border rounded-xl shadow-sm">
            <div>
                <select name="exam_id"
                        class="border-gray-300 rounded-lg text-gray-700 focus:ring-blue-300 focus:border-blue-400">
                    <option value="">-- Chọn bài thi --</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}" {{ $examId == $exam->id ? 'selected' : '' }}>
                            {{ $exam->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <input type="text"
                       name="student_id"
                       placeholder="ID sinh viên"
                       value="{{ $studentId }}"
                       class="border-gray-300 rounded-lg text-gray-700 focus:ring-blue-300 focus:border-blue-400"
                >
            </div>

            <div>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Lọc
                </button>
            </div>
        </form>

        {{-- Bảng kết quả --}}
        <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-900 text-sm uppercase font-semibold">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Sinh viên</th>
                        <th class="px-4 py-3">Bài thi</th>
                        <th class="px-4 py-3">Điểm</th>
                        <th class="px-4 py-3">Ngày nộp</th>
                        <th class="px-4 py-3 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $r)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-600">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $r->student->name }}</td>
                            <td class="px-4 py-3">{{ $r->exam->title }}</td>
                            <td class="px-4 py-3">
                                <span class="font-semibold text-green-600">{{ $r->total_score }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">
                                {{ \Carbon\Carbon::parse($r->submitted_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin.results.show', $r->id) }}"
                                   class="inline-flex items-center gap-1 bg-blue-600 text-white px-3 py-1.5 rounded-lg text-sm hover:bg-blue-700 transition">
                                    👁️ Xem chi tiết
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                Không có kết quả nào được tìm thấy.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-10 text-center">
                 <a href="{{ route('admin.dashboard') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">⬅ Quay lại</a>
            </div>
           

        {{-- Phân trang --}}
        <div class="mt-6">
            {{ $results->links('pagination::tailwind') }}
        </div>
    </div>

</x-app-layout>
