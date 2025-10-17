<nav x-data="{ open: false }" class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-md shadow-md sticky top-0 z-50 border-b border-gray-100 dark:border-gray-700 transition">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            {{-- Logo --}}
            <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('student.exams.index') }}" class="flex items-center gap-2">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" alt="Logo" class="w-8 h-8 transform hover:rotate-12 transition duration-500">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">OnlineExam</h1>
            </a>

            {{-- Desktop menu --}}
            <div class="hidden sm:flex sm:items-center gap-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent rounded-md text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-900 hover:text-gray-700 dark:hover:text-gray-300 transition">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-4 w-4 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger --}}
            <div class="sm:hidden flex items-center">
                <button @click="open = !open" class="p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 transition">
                    <svg class="h-6 w-6 transition-transform duration-300" :class="{'rotate-90': open}" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
            <x-responsive-nav-link :href="auth()->user()->is_admin ? route('admin.dashboard') : route('student.exams.index')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 px-4">
            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
