<x-app-layout>
    
        <div class="text-center mt-6">
            <h2 class="font-semibold text-2xl text-gray-800 mb-2">
                📝 Làm bài thi: <span class="text-blue-600">{{ $exam->title }}</span>
            </h2>
            <div id="timer" class="inline-block bg-red-100 text-red-700 font-bold px-5 py-2 rounded-lg shadow-md text-lg mt-2"></div>
        </div>


    

     <div class="py-8 max-w-5xl mx-auto px-6">
        <form id="examForm" 
              action="{{ route('exams.submit', $exam->id) }}" 
              method="POST" 
              class="space-y-6">
            @csrf

            @foreach($exam->questions as $index => $q)
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                    <p class="font-semibold text-gray-800 mb-4">
                        <span class="text-blue-600 font-bold">{{ $index + 1 }}.</span> 
                        {{ $q->question_text }}
                    </p>

                    {{-- Trắc nghiệm --}}
                    @if($q->type === 'multiple_choice')
                        @php $options = json_decode($q->options, true) ?? []; @endphp
                        <div class="space-y-2">
                            @foreach($options as $key => $opt)
                                @php
                                    $optionKey = strtoupper(is_numeric($key) ? chr(65 + $key) : $key); // A, B, C, D
                                @endphp
                                <label class="flex items-start space-x-2 cursor-pointer p-2 border rounded hover:bg-blue-50">
                                    <input type="radio" 
                                           name="answers[{{ $q->id }}]" 
                                           value="{{ $optionKey }}" 
                                           required
                                           class="mt-1 text-blue-600 focus:ring-blue-500">
                                    <span><strong>{{ $optionKey }}.</strong> {{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>

                    {{-- Tự luận --}}
                    @else
                        <textarea name="answers[{{ $q->id }}]" 
                                  class="w-full border border-gray-300 rounded-lg p-3 mt-2 focus:ring focus:ring-blue-200"
                                  rows="4" 
                                  placeholder="✍️ Nhập câu trả lời tại đây..."></textarea>
                    @endif
                </div>
            @endforeach

            {{-- Nút nộp bài --}}
            <div class="text-center pt-4">
                <button type="submit" 
                        class="bg-blue-600 text-white px-8 py-3 rounded-xl text-lg font-semibold shadow hover:bg-blue-700 transition">
                    📨 Nộp bài thi
                </button>
            </div>
        </form>
    </div>
    
    <script>
        let timeLeft = {{ $exam->duration * 60 }};
        const timerDisplay = document.getElementById('timer');
        const form = document.getElementById('examForm');
        const totalTime = timeLeft;

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            const percent = ((totalTime - timeLeft) / totalTime) * 100;

            timerDisplay.textContent = `⏳ Thời gian còn lại: ${minutes}:${seconds.toString().padStart(2, '0')}`;

            
            if (timeLeft <= 0) {
                clearInterval(timer);
                alert('⏰ Hết thời gian! Hệ thống sẽ tự động nộp bài.');
                form.submit();
            }

            
            if (timeLeft <= 120) {
                timerDisplay.classList.add('bg-red-600', 'text-white');
                timerDisplay.classList.remove('bg-white/20', 'text-yellow-100');
            }

            timeLeft--;
        }

        updateTimer();
        const timer = setInterval(updateTimer, 1000);
    </script>
</x-app-layout>
