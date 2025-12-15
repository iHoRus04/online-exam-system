<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // gọi seeder admin (firstOrCreate bên trong sẽ tránh tạo trùng)
        $this->call([
            \Database\Seeders\AdminUserSeeder::class,
        ]);

        // Nếu bạn muốn seed thêm Student account cũng idempotent:
        // \Database\Seeders\StudentUserSeeder::class,
    }
}