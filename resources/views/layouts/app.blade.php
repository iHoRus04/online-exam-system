<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- Navigation --}}
        @include('layouts.navigation')

        {{-- Page Header --}}
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Page Content --}}
        <main>
            {{ $slot }}
        </main>
    </div>
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
