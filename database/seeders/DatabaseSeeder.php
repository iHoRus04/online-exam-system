<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Gọi seeder admin & bài thi mẫu
        $this->call([
            AdminUserSeeder::class,
            ExamSeeder::class,
        ]);

        // Đảm bảo tài khoản Admin chính luôn tồn tại
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make(config('app.admin_password') ?: '12345678'),
                'is_admin' => true,
            ]
        );

        // Tài khoản Sinh viên mẫu
        User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ]
        );
    }
}