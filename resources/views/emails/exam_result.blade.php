<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả bài thi</title>
</head>
<body>
    <p>Xin chào {{ $result->student->name }},</p>
    <p>Bạn đã hoàn thành bài kiểm tra <strong>{{ $result->exam->title }}</strong>.</p>
    <p>Tổng điểm của bạn: <strong>{{ $result->total_score }}/100</strong></p>
    <p>Chúc mừng bạn! 🎉</p>
    <p>— Online Test System</p>
</body>
</html>
