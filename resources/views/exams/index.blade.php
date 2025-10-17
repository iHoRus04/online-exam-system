<x-app-layout>
    
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        
        {{-- ✅ Thông báo --}}
        @if(session('success'))
        <div 
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            x-transition.opacity.duration.500ms
            class="fixed top-6 right-6 z-50 max-w-md"
        >
            <div class="bg-white border-l-4 border-green-500 rounded-xl shadow-2xl p-4 flex items-start gap-3 backdrop-blur-lg">
                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-gray-800">Thành công!</h4>
                    <p class="text-gray-600 text-sm mt-1">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        {{-- 🧭 Header Section --}}
        <div class="text-center pt-12 pb-8 px-6">
            <div class="inline-block mb-6">
                <div class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-3xl flex items-center justify-center shadow-2xl transform hover:rotate-3 transition-transform duration-300">
                    <span class="text-5xl">📚</span>
                </div>
            </div>
            
            <h1 class="text-5xl font-extrabold mb-4 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                Danh sách bài thi
            </h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Chọn bài thi và thể hiện khả năng của bạn! 🚀
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-6 pb-16">
            
            {{-- 🔍 Search & Filter Bar --}}
            <form method="GET" class="mb-8">
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/50 p-6">
                    <div class="flex flex-col lg:flex-row gap-4">
                        
                        <!-- Search Input -->
                        <div class="flex-1 relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Tìm kiếm bài thi..." 
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-400 focus:ring-4 focus:ring-purple-100 transition-all">
                        </div>

                        <!-- Status Filter -->
                        <div class="relative">
                            <select name="status" class="appearance-none pl-4 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-400 focus:ring-4 focus:ring-purple-100 transition-all bg-white cursor-pointer min-w-[180px]">
                                <option value="">📊 Tất cả trạng thái</option>
                                <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>✅ Đã làm</option>
                                <option value="not_done" {{ request('status') == 'not_done' ? 'selected' : '' }}>🕒 Chưa làm</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Lọc
                        </button>
                    </div>
                </div>
            </form>

         
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-semibold mb-1">Tổng số bài thi</p>
                            <p class="text-4xl font-bold">{{ $exams->count() }}</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-3xl">
                            📝
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 text-white shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-semibold mb-1">Đã hoàn thành</p>
                            <p class="text-4xl font-bold">
                                {{ $exams->filter(function($exam) {
                                    return \App\Models\ExamResult::where('exam_id', $exam->id)
                                        ->where('student_id', auth()->id())->exists();
                                })->count() }}
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-3xl">
                            ✅
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-pink-600 rounded-2xl p-6 text-white shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-semibold mb-1">Chưa làm</p>
                            <p class="text-4xl font-bold">
                                {{ $exams->filter(function($exam) {
                                    return !\App\Models\ExamResult::where('exam_id', $exam->id)
                                        ->where('student_id', auth()->id())->exists();
                                })->count() }}
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-3xl">
                            🕒
                        </div>
                    </div>
                </div>
            </div>

            {{-- 📋 Exam Cards Grid --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($exams as $exam)
                    @php
                        $result = \App\Models\ExamResult::where('exam_id', $exam->id)
                                    ->where('student_id', auth()->id())
                                    ->first();
                    @endphp

                    <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 overflow-hidden hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
                        
                     
                        <div class="relative h-32 bg-gradient-to-br {{ $result ? 'from-green-400 to-emerald-500' : 'from-blue-400 via-purple-400 to-pink-500' }} p-6">
                            <div class="absolute top-4 right-4">
                                @if($result)
                                    <span class="bg-white/90 backdrop-blur-sm text-green-700 px-3 py-1 rounded-full text-xs font-bold shadow-lg flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Đã làm
                                    </span>
                                @else
                                    <span class="bg-white/90 backdrop-blur-sm text-orange-600 px-3 py-1 rounded-full text-xs font-bold shadow-lg flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Chưa làm
                                    </span>
                                @endif
                            </div>
                            
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-3xl shadow-lg">
                                    {{ $result ? '✅' : '📝' }}
                                </div>
                            </div>
                        </div>

                      
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-purple-600 transition-colors">
                                {{ $exam->title }}
                            </h3>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm"><strong>{{ $exam->duration }}</strong> phút</span>
                                </div>
                                
                                <div class="flex items-center gap-2 text-gray-600">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm"><strong>{{ $exam->total_questions }}</strong> câu hỏi</span>
                                </div>

                                @if($result)
                                <div class="flex items-center gap-2 text-gray-600">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm">Điểm: <strong class="text-green-600">{{ number_format($result->score, 1) }}</strong></span>
                                </div>
                                @endif
                            </div>

                            <!-- Action Button -->
                            @if(!$result)
                                <a href="{{ route('exams.take', $exam->id) }}" 
                                   class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white text-center py-3 rounded-xl font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 group/btn">
                                    <span class="flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                        Bắt đầu thi
                                    </span>
                                </a>
                            @else
                                <a href="{{ route('exams.result', $exam->id) }}" 
                                   class="block w-full bg-gradient-to-r from-gray-600 to-gray-700 text-white text-center py-3 rounded-xl font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 group/btn">
                                    <span class="flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                        Xem kết quả
                                    </span>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-16">
                        <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                            <span class="text-6xl">📭</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">Không tìm thấy bài thi</h3>
                        <p class="text-gray-500">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>