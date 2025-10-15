<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📝 Tạo bài thi mới
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        {{-- Hiển thị lỗi chung --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Lỗi!</strong> Vui lòng kiểm tra lại các trường sau:
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.exams.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf

            {{-- Tiêu đề --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Tiêu đề <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="title" 
                    value="{{ old('title') }}" 
                    placeholder="Nhập tiêu đề bài thi"
                    class="w-full border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                    required
                >
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Thời lượng --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Thời lượng (phút) <span class="text-red-500">*</span></label>
                <input 
                    type="number" 
                    name="duration" 
                    value="{{ old('duration') }}" 
                    min="1" step="1"
                    placeholder="VD: 60"
                    class="w-full border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('duration') border-red-500 @enderror"
                    required
                >
                @error('duration')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tổng số câu hỏi --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Tổng số câu hỏi <span class="text-red-500">*</span></label>
                <input 
                    type="number" 
                    name="total_questions" 
                    value="{{ old('total_questions') }}" 
                    min="1" step="1"
                    placeholder="VD: 20"
                    class="w-full border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('total_questions') border-red-500 @enderror"
                    required
                >
                @error('total_questions')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nút hành động --}}
            <div class="flex gap-3">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">💾 Lưu</button>
                <a href="{{ route('admin.exams.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">⬅ Quay lại</a>
            </div>
        </form>
    </div>
</x-app-layout>
