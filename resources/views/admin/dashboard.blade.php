<x-app-layout>
    <section class="min-h-[calc(100vh-100px)] max-w-7xl mx-auto px-6 py-10">
        {{-- Tiêu đề --}}
        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-gray-800 flex items-center justify-center gap-2">
                ⚙️ <span class="text-blue-600">ADMIN</span> DASHBOARD
            </h2>
            <p class="text-gray-500 mt-2 text-sm">Quản lý hệ thống thi trực tuyến — Theo dõi, thống kê và điều hành dễ dàng</p>
        </div>

        {{-- Thống kê tổng quan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-gradient-to-r from-blue-100 to-blue-50 border-l-4 border-blue-600 p-5 rounded-xl shadow-sm hover:shadow-md transition">
                <h3 class="text-gray-700 font-semibold text-sm">📘 Tổng số bài thi</h3>
                <p class="text-3xl font-bold text-blue-700 mt-2">{{ $examCount }}</p>
            </div>

            <div class="bg-gradient-to-r from-yellow-100 to-yellow-50 border-l-4 border-yellow-600 p-5 rounded-xl shadow-sm hover:shadow-md transition">
                <h3 class="text-gray-700 font-semibold text-sm">👩‍🎓 Số lượng sinh viên</h3>
                <p class="text-3xl font-bold text-yellow-700 mt-2">{{ $studentCount }}</p>
            </div>

            <div class="bg-gradient-to-r from-green-100 to-green-50 border-l-4 border-green-600 p-5 rounded-xl shadow-sm hover:shadow-md transition">
                <h3 class="text-gray-700 font-semibold text-sm">📊 Bài thi đã nộp</h3>
                <p class="text-3xl font-bold text-green-700 mt-2">{{ $resultCount }}</p>
            </div>

            <div class="bg-gradient-to-r from-purple-100 to-purple-50 border-l-4 border-purple-600 p-5 rounded-xl shadow-sm hover:shadow-md transition">
                <h3 class="text-gray-700 font-semibold text-sm">✅ Bài đã chấm</h3>
                <p class="text-3xl font-bold text-purple-700 mt-2">{{ $gradedCount }}</p>
            </div>
        </div>

        {{-- Khu vực điều hướng quản trị --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800">📘 Quản lý bài thi</h3>
                    <span class="text-sm text-gray-500">Tổng: {{ $examCount }}</span>
                </div>
                <p class="text-gray-600 mb-5">
                    Thêm, sửa, xóa bài thi và quản lý các câu hỏi trong từng bài.
                </p>
                <a href="{{ route('admin.exams.index') }}" 
                   class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                    ➜ Vào Quản lý bài thi
                </a>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-200 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800">📊 Quản lý kết quả</h3>
                    <span class="text-sm text-gray-500">Tổng: {{ $resultCount }}</span>
                </div>
                <p class="text-gray-600 mb-5">
                    Xem kết quả, chấm điểm tự luận và xuất báo cáo thống kê.
                </p>
                <a href="{{ route('admin.results.index') }}" 
                   class="inline-flex items-center gap-2 bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition">
                    ➜ Vào Quản lý kết quả
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
