# 🧩 Online Test System - Laravel Project

Hệ thống thi trắc nghiệm & tự luận trực tuyến được xây dựng bằng **Laravel 10**. README này hướng dẫn chi tiết cho người mới: cài đặt môi trường, cấu hình, chạy ứng dụng, tài khoản mẫu và hướng dẫn deploy online.

---

## 🌐 Live Demo & Tài liệu
- **Trang web Demo (Render):** [https://online-exam-system-h384.onrender.com](https://online-exam-system-h384.onrender.com)
- **File tài liệu mô tả chức năng:** [Google Docs Link](https://docs.google.com/document/d/1m1wDCpgNFdg1F5sZoyzzy0wezT0av_WM/edit?usp=sharing&ouid=113723149047881815542&rtpof=true&sd=true)

---

## ⚙️ 1. Yêu cầu hệ thống

Trước khi chạy dự án ở máy local, đảm bảo bạn đã cài:

- PHP >= 8.1
- Composer (https://getcomposer.org)
- Node.js + npm >= 16.x
- MySQL >= 5.7 (hoặc MariaDB / PostgreSQL)
- Git (tuỳ chọn)
- Editor (VSCode khuyến nghị)

---

## 🧱 2. Cài đặt môi trường (Local)

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

---

## 📥 3. Lấy mã nguồn & cài thư viện

Mở terminal (PowerShell / Terminal):

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

---

## ⚙️ 4. Cấu hình môi trường (.env)

1. Copy file mẫu:
```bash
cp .env.example .env
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
DB_PASSWORD=
```

3. Tạo app key:
```bash
php artisan key:generate
```

---

## 🗄️ 5. Tạo database & chạy migration + seed

1. Tạo database (phpMyAdmin hoặc MySQL CLI):
```sql
CREATE DATABASE online_test_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Chạy migration và seed dữ liệu mẫu (tạo sẵn bộ đề thi & tài khoản mẫu):
```bash
php artisan migrate --seed
```

- Nếu muốn xóa làm lại từ đầu:
```bash
php artisan migrate:fresh --seed
```

---

## 🚀 6. Chạy ứng dụng (local)

1. Chạy Laravel server:
```bash
php artisan serve
```
Mặc định: `http://127.0.0.1:8000`

2. Chạy Vite dev server (frontend hot-reload):
```bash
npm run dev
```

---

## 👥 7. Tài khoản mặc định (sau khi Seed)

| Vai trò | Email | Mật khẩu | Chức năng chính |
| :--- | :--- | :--- | :--- |
| **Quản trị viên (Admin)** | `admin@example.com` | `12345678` | Quản lý đề thi, câu hỏi trắc nghiệm & tự luận, chấm điểm tự luận |
| **Sinh viên (Student)** | `student@example.com` | `12345678` | Xem danh sách đề thi, làm bài thi, nộp bài & xem điểm |

---

## 🧪 8. Hướng dẫn test luồng ứng dụng

### A. Luồng Student (Sinh viên)
1. Đăng nhập bằng tài khoản `student@example.com` / `12345678`.
2. Vào **Dashboard** → Chọn bài thi mẫu → Nhấn **Bắt đầu làm bài**.
3. Làm bài: Chọn đáp án trắc nghiệm (A, B, C, D) và nhập câu trả lời tự luận.
4. Nộp bài → Xem kết quả trực quan (điểm trắc nghiệm tự động).

### B. Luồng Admin (Quản trị viên)
1. Đăng nhập bằng tài khoản `admin@example.com` / `12345678`.
2. Quản lý đề thi: Thêm/Sửa/Xóa đề thi, thêm câu hỏi (Trắc nghiệm/Tự luận).
3. Vào mục **Kết quả thi (Results)** → Chọn bài làm sinh viên → Chấm điểm câu tự luận & lưu điểm tổng.

---

## ☁️ 9. Deploy Online (Render + Neon PostgreSQL)

Dự án được cấu hình sẵn để deploy mượt mà trên **Render.com** kết nối tới **Neon.tech (PostgreSQL)**:
1. Tạo PostgreSQL Database miễn phí trên [Neon.tech](https://neon.tech/).
2. Đẩy code lên GitHub nhánh `render-deploy` hoặc `main`.
3. Tạo Web Service trên Render, liên kết với repo GitHub và cấu hình các biến môi trường DB (`DB_CONNECTION=pgsql`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `DB_SSLMODE=require`).
4. Hệ thống sẽ tự động chạy migration, seed tài khoản & đề thi mẫu vĩnh viễn không sợ mất dữ liệu.