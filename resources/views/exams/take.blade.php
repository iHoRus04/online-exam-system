<x-app-layout>
    <!-- Background gradient overlay -->
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50">
        
        <!-- Header Section -->
        <div class="text-center pt-10 pb-6 px-6">
            <div class="inline-block animate-pulse mb-4">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-300">
                    <span class="text-4xl">📝</span>
                </div>
            </div>
            
            <h2 class="font-extrabold text-4xl md:text-5xl mb-4 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent leading-tight">
                {{ $exam->title }}
            </h2>
            
            <p class="text-gray-600 text-lg mb-6">Hãy làm bài cẩn thận và tự tin!</p>
            
            <!-- Timer với animation -->
            <div id="timer" 
                 class="inline-flex items-center gap-3 bg-gradient-to-r from-amber-400 to-orange-500 text-white font-bold px-8 py-4 rounded-2xl shadow-2xl text-xl transform hover:scale-105 transition-all duration-300">
                <svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-width="2" stroke-dasharray="63" stroke-dashoffset="0">
                        <animate attributeName="stroke-dashoffset" from="0" to="63" dur="60s" repeatCount="indefinite"/>
                    </circle>
                </svg>
                <span id="timer-text"></span>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-6 pb-16">
            
          
            <!-- Tab Navigation với glassmorphism -->
            <div class="flex justify-center mb-10">
                <div class="inline-flex bg-white/70 backdrop-blur-xl rounded-2xl p-2 shadow-2xl border border-white/20">
                    <button type="button" data-tab="multiple_choice" 
                            class="tab-btn active px-8 py-3 rounded-xl font-bold text-white bg-gradient-to-r from-blue-500 to-purple-600 shadow-lg transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Trắc nghiệm
                        
                    </button>
                    <button type="button" data-tab="essay" 
                            class="tab-btn px-8 py-3 rounded-xl font-bold text-gray-700 hover:bg-gray-100/50 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Tự luận
                        
                    </button>
                </div>
            </div>

            <form id="examForm" 
                  action="{{ route('exams.submit', $exam->id) }}" 
                  method="POST" 
                  class="space-y-6">
                @csrf

                {{-- Trắc nghiệm --}}
                <div id="tab-multiple_choice" class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    
                    <!-- Question Navigator - Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 shadow-2xl border border-white/20 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                                Danh sách câu hỏi
                            </h3>
                            <div id="mc-navigator" class="grid grid-cols-5 gap-2">
                                @foreach($exam->questions->where('type', 'multiple_choice') as $index => $q)
                                    <button type="button" 
                                            data-question="{{ $q->id }}"
                                            data-type="mc"
                                            onclick="scrollToQuestion('mc-{{ $q->id }}')"
                                            class="question-nav w-10 h-10 rounded-lg border-2 border-gray-300 bg-white hover:border-blue-400 transition-all duration-300 font-semibold text-gray-600 hover:scale-110">
                                        {{ $index + 1 }}
                                    </button>
                                @endforeach
                            </div>
                            <div class="mt-6 space-y-2 text-xs">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded border-2 border-gray-300 bg-white"></div>
                                    <span class="text-gray-600">Chưa làm</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded bg-gradient-to-br from-green-400 to-emerald-500 border-2 border-green-500"></div>
                                    <span class="text-gray-600">Đã làm</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Questions -->
                    <div class="lg:col-span-3 space-y-6">
                    @foreach($exam->questions->where('type', 'multiple_choice') as $index => $q)
                        <div id="mc-{{ $q->id }}" class="group mb-6 transform hover:scale-[1.01] transition-all duration-300 scroll-mt-6">
                            <div class="bg-white/80 backdrop-blur-sm p-8 rounded-3xl shadow-xl border border-white/50 hover:shadow-2xl hover:border-purple-200">
                                
                                <!-- Question number badge -->
                                <div class="flex items-start gap-4 mb-6">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        {{ $index + 1 }}
                                    </div>
                                    <p class="flex-1 font-semibold text-gray-800 text-lg leading-relaxed pt-2">
                                        {{ $q->question_text }}
                                    </p>
                                </div>

                                @php $options = json_decode($q->options, true) ?? []; @endphp
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ml-16">
                                    @foreach($options as $key => $opt)
                                        @php
                                            $optionKey = strtoupper(is_numeric($key) ? chr(65 + $key) : $key);
                                            $colors = ['blue', 'purple', 'pink', 'indigo'];
                                            $color = $colors[$key % 4];
                                        @endphp
                                        <label class="relative flex items-start cursor-pointer group/option">
                                            <input type="radio" 
                                                   name="answers[{{ $q->id }}]" 
                                                   value="{{ $optionKey }}" 
                                                   data-question="{{ $q->id }}"
                                                   onchange="markQuestionAnswered({{ $q->id }}, 'mc')"
                                                   required
                                                   class="peer sr-only">
                                            
                                            <div class="flex items-start gap-3 w-full p-5 border-2 border-gray-200 rounded-2xl transition-all duration-300 
                                                        peer-checked:border-{{ $color }}-500 peer-checked:bg-gradient-to-br peer-checked:from-{{ $color }}-50 peer-checked:to-{{ $color }}-100 
                                                        hover:border-{{ $color }}-300 hover:shadow-lg hover:scale-[1.02]">
                                                
                                                <div class="flex-shrink-0 w-8 h-8 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all
                                                            peer-checked:border-{{ $color }}-500 peer-checked:bg-{{ $color }}-500 peer-checked:text-white font-bold">
                                                    <span class="text-sm opacity-0 peer-checked:opacity-100">✓</span>
                                                    <span class="absolute text-{{ $color }}-600 font-bold peer-checked:hidden">{{ $optionKey }}</span>
                                                </div>
                                                
                                                <span class="flex-1 text-gray-700 leading-relaxed peer-checked:text-gray-900 peer-checked:font-semibold">
                                                    {{ $opt }}
                                                </span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>

                {{-- Tự luận --}}
                <div id="tab-essay" class="hidden grid grid-cols-1 lg:grid-cols-4 gap-6">
                    
                    <!-- Question Navigator - Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 shadow-2xl border border-white/20 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                                Danh sách câu hỏi
                            </h3>
                            <div id="essay-navigator" class="grid grid-cols-5 gap-2">
                                @foreach($exam->questions->where('type', 'essay') as $index => $q)
                                    <button type="button" 
                                            data-question="{{ $q->id }}"
                                            data-type="essay"
                                            onclick="scrollToQuestion('essay-{{ $q->id }}')"
                                            class="question-nav w-10 h-10 rounded-lg border-2 border-gray-300 bg-white hover:border-pink-400 transition-all duration-300 font-semibold text-gray-600 hover:scale-110">
                                        {{ $index + 1 }}
                                    </button>
                                @endforeach
                            </div>
                            <div class="mt-6 space-y-2 text-xs">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded border-2 border-gray-300 bg-white"></div>
                                    <span class="text-gray-600">Chưa làm</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded bg-gradient-to-br from-green-400 to-emerald-500 border-2 border-green-500"></div>
                                    <span class="text-gray-600">Đã làm</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Questions -->
                    <div class="lg:col-span-3 space-y-6">
                    @foreach($exam->questions->where('type', 'essay') as $index => $q)
                        <div id="essay-{{ $q->id }}" class="group mb-6 transform hover:scale-[1.01] transition-all duration-300 scroll-mt-6">
                            <div class="bg-white/80 backdrop-blur-sm p-8 rounded-3xl shadow-xl border border-white/50 hover:shadow-2xl hover:border-purple-200">
                                
                                <div class="flex items-start gap-4 mb-6">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-pink-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        {{ $index + 1 }}
                                    </div>
                                    <p class="flex-1 font-semibold text-gray-800 text-lg leading-relaxed pt-2">
                                        {{ $q->question_text }}
                                    </p>
                                </div>

                                <div class="ml-16">
                                    <textarea name="answers[{{ $q->id }}]" 
                                              data-question="{{ $q->id }}"
                                              oninput="markQuestionAnswered({{ $q->id }}, 'essay')"
                                              class="w-full border-2 border-gray-200 rounded-2xl p-6 focus:ring-4 focus:ring-purple-200 focus:border-purple-400 transition-all text-gray-800 resize-none hover:border-purple-300"
                                              rows="6" 
                                              placeholder="✍️ Nhập câu trả lời của bạn tại đây..."></textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>

                {{-- Nút nộp bài với animation --}}
                <div class="text-center pt-10">
                    <button type="submit" 
                            class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white px-12 py-5 rounded-2xl text-xl font-bold shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 overflow-hidden">
                        <span class="absolute inset-0 bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                        <svg class="w-6 h-6 relative z-10 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="relative z-10">Nộp bài thi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tracking answered questions
        const totalQuestions = {{ $exam->questions->count() }};
        const totalMC = {{ $exam->questions->where('type', 'multiple_choice')->count() }};
        const totalEssay = {{ $exam->questions->where('type', 'essay')->count() }};
        const answeredQuestions = new Set();

        function updateProgress() {
            const answered = answeredQuestions.size;
            const percentage = (answered / totalQuestions) * 100;
            
            document.getElementById('progress-bar').style.width = percentage + '%';
            document.getElementById('progress-text').textContent = `${answered}/${totalQuestions}`;
            
            // Update tab counters
            const mcAnswered = Array.from(answeredQuestions).filter(id => {
                const nav = document.querySelector(`[data-question="${id}"][data-type="mc"]`);
                return nav !== null;
            }).length;
            
            const essayAnswered = Array.from(answeredQuestions).filter(id => {
                const nav = document.querySelector(`[data-question="${id}"][data-type="essay"]`);
                return nav !== null;
            }).length;
            
            document.getElementById('mc-count').textContent = `${mcAnswered}/${totalMC}`;
            document.getElementById('essay-count').textContent = `${essayAnswered}/${totalEssay}`;
        }

        function markQuestionAnswered(questionId, type) {
            answeredQuestions.add(questionId);
            
            // Update navigator button
            const navButton = document.querySelector(`[data-question="${questionId}"][data-type="${type}"]`);
            if (navButton) {
                navButton.classList.remove('border-gray-300', 'bg-white', 'text-gray-600');
                navButton.classList.add('bg-gradient-to-br', 'from-green-400', 'to-emerald-500', 'border-green-500', 'text-white', 'shadow-lg');
            }
            
            updateProgress();
        }

        function scrollToQuestion(elementId) {
            const element = document.getElementById(elementId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                element.classList.add('ring-4', 'ring-purple-300');
                setTimeout(() => {
                    element.classList.remove('ring-4', 'ring-purple-300');
                }, 2000);
            }
        }

        // Timer
        let timeLeft = {{ $exam->duration * 60 }};
        const timerDisplay = document.getElementById('timer');
        const timerText = document.getElementById('timer-text');
        const form = document.getElementById('examForm');

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerText.textContent = `${minutes}:${seconds.toString().padStart(2,'0')}`;

            if(timeLeft <= 0) {
                clearInterval(timer);
                alert('⏰ Hết thời gian! Hệ thống sẽ tự động nộp bài.');
                form.submit();
            }

            if(timeLeft <= 120) {
                timerDisplay.classList.remove('from-amber-400', 'to-orange-500');
                timerDisplay.classList.add('from-red-500', 'to-pink-600', 'animate-pulse');
            }

            timeLeft--;
        }

        updateTimer();
        const timer = setInterval(updateTimer, 1000);

        // Tab functionality với animation
        const tabs = document.querySelectorAll('.tab-btn');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.tab;
                
                // Ẩn tất cả tab với fade out
                document.querySelectorAll('#tab-multiple_choice, #tab-essay').forEach(el => {
                    el.classList.add('hidden');
                });
                
                // Hiển thị tab chọn với fade in
                const selectedTab = document.getElementById(`tab-${target}`);
                selectedTab.classList.remove('hidden');
                selectedTab.style.animation = 'fadeIn 0.5s ease-in';

                // Active button styling
                tabs.forEach(btn => {
                    btn.classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-purple-600', 'text-white', 'shadow-lg', 'active');
                    btn.classList.add('text-gray-700', 'hover:bg-gray-100/50');
                });
                
                tab.classList.remove('text-gray-700', 'hover:bg-gray-100/50');
                tab.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-purple-600', 'text-white', 'shadow-lg', 'active');
            });
        });

        // Add fadeIn animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(style);

        // Initialize progress on page load
        updateProgress();
    </script>
</x-app-layout>