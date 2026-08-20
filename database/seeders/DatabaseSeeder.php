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

        // Tài khoản Sinh viên mẫu
        User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );
    }
}