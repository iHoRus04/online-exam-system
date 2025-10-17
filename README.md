# 🧩 Online Test System - Laravel Project

Hệ thống thi trắc nghiệm trực tuyến được xây dựng bằng **Laravel 10**. README này hướng dẫn chi tiết cho người mới: cài đặt môi trường, cấu hình, chạy ứng dụng và cách test từng bước.

---

## ⚙️ 1. Yêu cầu hệ thống

Trước khi chạy dự án, đảm bảo bạn đã cài:

- PHP >= 8.1
- Composer (https://getcomposer.org)
- Node.js + npm >= 16.x
- MySQL >= 5.7 (hoặc MariaDB)
- Git (tuỳ chọn)
- Editor (VSCode khuyến nghị)

---
## 🧱 2. Cài đặt môi trường (bước từng bước)

### 2.1 Cài XAMPP / PHP (Windows)
- Tải XAMPP: https://www.apachefriends.org/download.html
- Mở XAMPP Control Panel → Bật `Apache` và `MySQL`.

### 2.2 Cài Composer
- Tải & cài: https://getcomposer.org/download/
- Kiểm tra:
```bash
composer -V
```

### 2.3 Cài Node.js & npm
- Tải: https://nodejs.org
- Kiểm tra:
```bash
node -v
npm -v
```

### 2.4 (Tuỳ) Cài Git
```bash
git --version
```

---

## 📥 3. Lấy mã nguồn & cài thư viện

Mở terminal (PowerShell/Terminal):

1. Clone repo
```bash
git clone https://github.com/iHoRus04/online-exam-system.git
cd online-exam-system
```

2. Cài PHP packages và JS packages
```bash
composer install
npm install
```

- Nếu composer báo lỗi thiếu extension (ví dụ zip, mbstring), mở `php.ini` và bật các extension tương ứng, sau đó restart Apache/PHP-FPM.

---

## ⚙️ 4. Cấu hình môi trường (.env)

1. Copy file mẫu:
```bash
cp .env.example .env
# Windows PowerShell:
# copy .env.example .env
```

2. Mở `.env` chỉnh những giá trị chính:
```env
APP_NAME="Online Exam System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=online_test_system
DB_USERNAME=root
DB_PASSWORD=            # nếu để trống thì để rỗng
```

3. Tạo app key:
```bash
php artisan key:generate
```

---

## 🗄️ 5. Tạo database & chạy migration + seed

1. Tạo database (phpMyAdmin hoặc MySQL CLI)
```sql
CREATE DATABASE online_test_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Chạy migration và seed dữ liệu mẫu:
```bash
php artisan migrate --seed
```

- Nếu muốn xóa và tạo lại:
```bash
php artisan migrate:fresh --seed
```

---

## 🚀 6. Chạy ứng dụng (local)

1. Chạy Laravel server:
```bash
php artisan serve
```
Mặc định: http://127.0.0.1:8000

2. Chạy Vite dev server (frontend hot-reload):
```bash
npm run dev
```

Mở trình duyệt truy cập: http://127.0.0.1:8000

---

## 👥 7. Tài khoản mặc định (sau seed)

- Admin: admin@example.com / password  
- Student: student@example.com / password

Nếu cần tạo admin thủ công:
```bash
php artisan tinker
# sau đó trong tinker:
$u = new App\Models\User();
$u->name = 'Admin';
$u->email = 'admin@example.com';
$u->password = bcrypt('password');
$u->is_admin = 1;
$u->save();
```

---

## 🧪 8. Hướng dẫn test (bằng tay & tự động)

A. Test bằng tay — luồng Student
1. Đăng nhập bằng `student@example.com`.
2. Vào Dashboard → Chọn exam → Start.
3. Làm bài: chọn đáp án trắc nghiệm, nhập câu tự luận.
4. Nộp bài → Xem kết quả.

B. Test bằng tay — luồng Admin
1. Đăng nhập bằng `admin@example.com`.
2. Quản lý exam: Thêm/sửa/xóa exam, thêm câu hỏi (MCQ/Essay).
3. Vào Submissions/Results → Mở submission → chấm câu tự luận → lưu → kiểm tra điểm tổng.



## ✉️ 9. Cấu hình email (local)

A. Log mail (khuyến nghị local)
Trong `.env`:
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Online Exam System"
```
Email sẽ ghi vào `storage/logs/laravel.log`.

