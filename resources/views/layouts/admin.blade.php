<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">

        
        <aside class="w-64 bg-white border-r border-gray-200 p-5 hidden md:block">
            <h2 class="text-lg font-semibold mb-4">Admin Panel</h2>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                    🏠 Dashboard
                </a>
                <a href="{{ route('admin.exams.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.exams.*') ? 'bg-gray-200 font-semibold' : '' }}">
                    📝 Quản lý bài thi
                </a>
                <a href="#" class="block px-3 py-2 rounded hover:bg-gray-100">
                    👥 Quản lý người dùng
                </a>
            </nav>
        </aside>

       
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
</x-app-layout>
