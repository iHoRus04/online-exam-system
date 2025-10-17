<x-app-layout>
    <section class="min-h-[calc(100vh-100px)] max-w-7xl mx-auto px-6 py-10">

        {{-- Tiêu đề --}}
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 flex items-center justify-center gap-2">
                ⚙️ <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">ADMIN DASHBOARD</span>
            </h2>
            <p class="text-gray-500 mt-2 text-sm md:text-base">Quản lý hệ thống thi trực tuyến — Theo dõi, thống kê và điều hành dễ dàng</p>
        </div>

        {{-- Thống kê tổng quan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            @php
                $stats = [
                    ['label'=>'Tổng số bài thi','value'=>$examCount,'icon'=>'📘','from'=>'blue-100','to'=>'blue-50','border'=>'blue-600'],
                    ['label'=>'Số lượng sinh viên','value'=>$studentCount,'icon'=>'👩‍🎓','from'=>'yellow-100','to'=>'yellow-50','border'=>'yellow-600'],
                    ['label'=>'Bài thi đã nộp','value'=>$resultCount,'icon'=>'📊','from'=>'green-100','to'=>'green-50','border'=>'green-600'],
                    ['label'=>'Bài đã chấm','value'=>$gradedCount,'icon'=>'✅','from'=>'purple-100','to'=>'purple-50','border'=>'purple-600'],
                ];
            @endphp

            @foreach($stats as $stat)
            <div class="bg-gradient-to-r from-{{ $stat['from'] }} to-{{ $stat['to'] }} border-l-4 border-{{ $stat['border'] }} p-5 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all">
                <h3 class="text-gray-700 font-semibold text-sm flex items-center gap-2">{{ $stat['icon'] }} {{ $stat['label'] }}</h3>
                <p class="text-3xl font-bold text-{{ $stat['border'] }} mt-2">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Khu vực điều hướng quản trị --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Quản lý bài thi --}}
            <div class="bg-white/70 dark:bg-gray-800 backdrop-blur-md p-8 rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700 hover:shadow-3xl transform hover:-translate-y-1 transition-all">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">📘 Quản lý bài thi</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Tổng: {{ $examCount }}</span>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-5">
                    Thêm, sửa, xóa bài thi và quản lý các câu hỏi trong từng bài.
                </p>
                <a href="{{ route('admin.exams.index') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-3 rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 transition transform font-medium">
                    ➜ Vào Quản lý bài thi
                </a>
            </div>

            {{-- Quản lý kết quả --}}
            <div class="bg-white/70 dark:bg-gray-800 backdrop-blur-md p-8 rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700 hover:shadow-3xl transform hover:-translate-y-1 transition-all">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">📊 Quản lý kết quả</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Tổng: {{ $resultCount }}</span>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-5">
                    Xem kết quả, chấm điểm tự luận và xuất báo cáo thống kê.
                </p>
                <a href="{{ route('admin.results.index') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-5 py-3 rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 transition transform font-medium">
                    ➜ Vào Quản lý kết quả
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
