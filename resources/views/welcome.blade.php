<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlineExam - Hệ thống thi trực tuyến</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-blue-50 via-white to-blue-100 text-gray-800 flex flex-col min-h-screen">

    {{-- Header / Navbar --}}
    <header class="bg-white/70 dark:bg-gray-900/70 backdrop-blur-md shadow-md sticky top-0 z-50 border-b border-gray-200 dark:border-gray-700 transition-colors duration-300">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">

            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" alt="Logo" class="w-10 h-10 transform hover:rotate-12 transition-transform duration-500">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-blue-600 dark:text-blue-400 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                    OnlineExam
                </h1>
            </div>

            {{-- Navigation --}}
            <div class="space-x-3 flex items-center">
                @auth
                    <a href="{{ url('/dashboard') }}" 
                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-2 rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 transition transform font-medium">
                        Vào hệ thống
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                    class="text-blue-600 dark:text-blue-400 font-semibold hover:underline transition-colors duration-300">
                    Đăng nhập
                    </a>
                    <a href="{{ route('register') }}" 
                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-2 rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 transition transform font-medium">
                    Đăng ký
                    </a>
                @endauth
            </div>
        </div>
    </header>


   <section class="flex flex-col-reverse md:flex-row items-center justify-center min-h-[calc(100vh-70px)] max-w-7xl mx-auto px-6 gap-10">

        {{-- Text content --}}
        <div class="text-center md:text-left max-w-xl space-y-6">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                Thi Trực Tuyến<br>
                <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                    Dễ Dàng & Hiệu Quả
                </span>
            </h2>
            <p class="text-gray-600 text-lg">
                Nền tảng thi trắc nghiệm & tự luận giúp giáo viên quản lý bài thi, sinh viên làm bài mọi lúc — an toàn, tiện lợi và nhanh chóng.
            </p>
            <a href="{{ route('register') }}" 
            class="inline-block bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-2xl text-lg font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition transform duration-300">
                🚀 Bắt đầu ngay
            </a>
        </div>

        {{-- Illustration --}}
        <div class="w-full md:w-1/2 flex justify-center relative">
            <div class="bg-gradient-to-tr from-blue-100 via-purple-100 to-pink-100 rounded-3xl p-6 shadow-2xl animate-fade-in hover:scale-105 transition-transform duration-500">
                <img src="https://cdn-icons-png.flaticon.com/512/906/906175.png" 
                    alt="Online Exam Illustration" 
                    class="w-80 md:w-96 mx-auto">
            </div>
            {{-- Optional floating elements --}}
            <div class="absolute -top-6 -left-6 w-16 h-16 bg-blue-300 rounded-full opacity-50 animate-bounce-slow"></div>
            <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-pink-300 rounded-full opacity-40 animate-bounce-slow"></div>
        </div>
    </section>

    {{-- Tailwind animation --}}
    <style>
    @keyframes fade-in {
        0% { opacity: 0; transform: translateY(20px);}
        100% { opacity: 1; transform: translateY(0);}
    }
    .animate-fade-in { animation: fade-in 1s ease-out forwards; }

    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0);}
        50% { transform: translateY(-10px);}
    }
    .animate-bounce-slow { animation: bounce-slow 4s infinite; }
    </style>


   

    

    
    <footer class="bg-gray-900 text-gray-300 py-6">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 px-6">
            {{-- Liên hệ --}}
            <p class="flex items-center gap-2 text-sm md:text-base">
                📧 Liên hệ: 
                <a href="mailto:support@onlineexam.vn" class="text-blue-400 hover:text-blue-500 hover:underline transition-colors">
                    support@onlineexam.vn
                </a>
            </p>

            {{-- Thông tin bản quyền --}}
            <p class="text-sm md:text-base text-gray-400">
                © {{ date('Y') }} <span class="text-white font-semibold">OnlineExam</span> — Nền tảng thi trực tuyến thông minh.
            </p>

            {{-- Social icons (tùy chọn) --}}
            <div class="flex items-center gap-4">
                <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors text-lg">🐦</a>
                <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors text-lg">💬</a>
                <a href="#" class="text-gray-400 hover:text-pink-400 transition-colors text-lg">📘</a>
            </div>
        </div>
    </footer>

</body>
</html>
