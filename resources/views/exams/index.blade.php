<x-app-layout>
        @if (session('success'))
            <div id="alert-success"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-700"
                role="alert">
                <strong class="font-bold">Thành công!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.remove()">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Đóng</title>
                        <path
                            d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z" />
                    </svg>
                </span>
            </div>

            <script>
               
                setTimeout(() => {
                    const alertBox = document.getElementById('alert-success');
                    if (alertBox) {
                        alertBox.style.opacity = '0';
                        setTimeout(() => alertBox.remove(), 700);
                    }
                }, 3000);
            </script>
        @endif


        
        <h2 class="font-semibold text-xl text-center text-gray-800 leading-tight mt-5">
            📚 Danh sách bài thi
        </h2>
  

    <div class="py-6 max-w-4xl mx-auto">
        @forelse($exams as $exam)
            <div class="bg-white p-6 rounded shadow mb-4 hover:shadow-md transition">
                <h2 class="text-lg font-semibold">{{ $exam->title }}</h2>
                <p class="text-gray-600 mt-1">⏱ Thời gian: {{ $exam->duration }} phút</p>
                <p class="text-gray-600">❓ Tổng số câu hỏi: {{ $exam->total_questions }}</p>
                <a href="{{ route('exams.take', $exam->id) }}" 
                   class="inline-block mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                   Bắt đầu thi
                </a>
            </div>
        @empty
            <p class="text-gray-500 text-center mt-6">Hiện tại chưa có bài thi nào.</p>
        @endforelse
    </div>
</x-app-layout>
