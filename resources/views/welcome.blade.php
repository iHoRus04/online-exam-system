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
    <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
            <div class="flex items-center gap-2">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" alt="Logo" class="w-8 h-8">
                <h1 class="text-2xl font-bold text-blue-600">OnlineExam</h1>
            </div>
            
           
            <div class="space-x-3">
                @auth
                    <a href="{{ url('/dashboard') }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Vào hệ thống
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="text-blue-600 font-semibold hover:underline">Đăng nhập</a>
                    <a href="{{ route('register') }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Đăng ký
                    </a>
                @endauth
            </div>
        </div>
    </header>

   <section class="flex flex-col-reverse md:flex-row items-center justify-center min-h-[calc(100vh-70px)] max-w-7xl mx-auto px-6 gap-10">

        <div class="text-center md:text-left max-w-xl">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                Thi Trực Tuyến<br><span class="text-blue-600">Dễ Dàng & Hiệu Quả</span>
            </h2>
            <p class="text-gray-600 text-lg mb-8">
                Nền tảng thi trắc nghiệm & tự luận giúp giáo viên quản lý bài thi, sinh viên làm bài mọi lúc — an toàn, tiện lợi và nhanh chóng.
            </p>
            <a href="{{ route('register') }}" 
               class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-medium hover:bg-blue-700 transition">
                🚀 Bắt đầu ngay
            </a>
        </div>

        <div class="w-full md:w-1/2 flex justify-center ">
            <img src="https://cdn-icons-png.flaticon.com/512/906/906175.png" 
                 alt="Online Exam Illustration" 
                 class="w-80 md:w-96 drop-shadow-xl animate-fade-in">
        </div>
    </section>

   

    

    
    <footer  class="bg-gray-900 text-gray-300 py-3 ">
        <div class="max-w-6xl mx-auto text-center space-y-2">
            <p>📧 Liên hệ: 
                <a href="mailto:support@onlineexam.vn" class="text-blue-400 hover:underline">support@onlineexam.vn</a>
            </p>
            <p>© {{ date('Y') }} <span class="text-white font-semibold">OnlineExam</span> — Nền tảng thi trực tuyến thông minh.</p>
        </div>
    </footer>

</body>
</html>
