<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('app.admin_email') ?: env('ADMIN_EMAIL') ?: 'admin@example.com';
        $password = config('app.admin_password') ?: env('ADMIN_PASSWORD') ?: 'password';
        $name = env('ADMIN_NAME') ?: 'Admin';

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );

        // Đảm bảo admin@example.com luôn đăng nhập được với mật khẩu
        if ($email !== 'admin@example.com') {
            User::updateOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin',
                    'password' => Hash::make('password'),
                    'is_admin' => true,
                ]
            );
        }
    }
}