<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------------------------------------
        // BÀI THI 1: Lập trình Web & Framework Laravel
        // ---------------------------------------------------------
        $exam1 = Exam::updateOrCreate(
            ['title' => 'Kiểm Tra Lập Trình Web & Laravel Cơ Bản'],
            [
                'duration' => 45,
                'total_questions' => 7,
            ]
        );

        $mcQuestions1 = [
            [
                'question_text' => 'Mô hình thiết kế kiến trúc chính mà Laravel framework áp dụng là gì?',
                'options' => [
                    'A' => 'MVP (Model-View-Presenter)',
                    'B' => 'MVC (Model-View-Controller)',
                    'C' => 'MVVM (Model-View-ViewModel)',
                    'D' => 'Microservices Architecture',
                ],
                'correct_answer' => 'B',
            ],
            [
                'question_text' => 'Trong Laravel, ORM mặc định được sử dụng để tương tác với cơ sở dữ liệu là gì?',
                'options' => [
                    'A' => 'Doctrine',
                    'B' => 'Prisma',
                    'C' => 'Eloquent ORM',
                    'D' => 'Hibernate',
                ],
                'correct_answer' => 'C',
            ],
            [
                'question_text' => 'Lệnh Artisan nào được dùng để tạo một Controller mới trong dự án Laravel?',
                'options' => [
                    'A' => 'php artisan create:controller',
                    'B' => 'php artisan make:controller',
                    'C' => 'php artisan generate:controller',
                    'D' => 'php artisan new:controller',
                ],
                'correct_answer' => 'B',
            ],
            [
                'question_text' => 'Template engine mặc định cực kỳ mạnh mẽ của Laravel có tên là gì?',
                'options' => [
                    'A' => 'Twig',
                    'B' => 'Smarty',
                    'C' => 'Blade',
                    'D' => 'EJS',
                ],
                'correct_answer' => 'C',
            ],
            [
                'question_text' => 'File nào dùng để khai báo các route đường dẫn cho giao diện Web trong Laravel?',
                'options' => [
                    'A' => 'routes/api.php',
                    'B' => 'routes/web.php',
                    'C' => 'routes/console.php',
                    'D' => 'config/app.php',
                ],
                'correct_answer' => 'B',
            ],
        ];

        foreach ($mcQuestions1 as $q) {
            Question::updateOrCreate(
                [
                    'exam_id' => $exam1->id,
                    'question_text' => $q['question_text'],
                ],
                [
                    'type' => 'multiple_choice',
                    'options' => $q['options'],
                    'correct_answer' => $q['correct_answer'],
                ]
            );
        }

        $essayQuestions1 = [
            [
                'question_text' => 'Trình bày vai trò của Middleware trong Laravel. Nêu ví dụ về một trường hợp thực tế cần sử dụng Middleware.',
            ],
            [
                'question_text' => 'Phân biệt sự khác nhau giữa Migration và Seeder trong Laravel. Tại sao nên sử dụng Migration thay vì tạo bảng bằng công cụ GUI trực tiếp?',
            ],
        ];

        foreach ($essayQuestions1 as $q) {
            Question::updateOrCreate(
                [
                    'exam_id' => $exam1->id,
                    'question_text' => $q['question_text'],
                ],
                [
                    'type' => 'essay',
                    'options' => null,
                    'correct_answer' => null,
                ]
            );
        }

        // ---------------------------------------------------------
        // BÀI THI 2: Cơ Sở Dữ Liệu & Truy Vấn SQL
        // ---------------------------------------------------------
        $exam2 = Exam::updateOrCreate(
            ['title' => 'Kiểm Tra Kiến Thức Cơ Sở Dữ Liệu & SQL'],
            [
                'duration' => 30,
                'total_questions' => 5,
            ]
        );

        $mcQuestions2 = [
            [
                'question_text' => 'Từ khóa nào trong SQL được sử dụng để lấy dữ liệu không bị trùng lặp?',
                'options' => [
                    'A' => 'UNIQUE',
                    'B' => 'DISTINCT',
                    'C' => 'DIFFERENT',
                    'D' => 'GROUP BY',
                ],
                'correct_answer' => 'B',
            ],
            [
                'question_text' => 'Loại JOIN nào sẽ trả về tất cả các bản ghi từ bảng bên trái và các bản ghi khớp từ bảng bên phải?',
                'options' => [
                    'A' => 'INNER JOIN',
                    'B' => 'RIGHT JOIN',
                    'C' => 'LEFT JOIN',
                    'D' => 'FULL OUTER JOIN',
                ],
                'correct_answer' => 'C',
            ],
            [
                'question_text' => 'Khóa chính (Primary Key) trong một bảng quan hệ có đặc điểm gì?',
                'options' => [
                    'A' => 'Có thể chứa giá trị NULL',
                    'B' => 'Không được chứa giá trị trùng lặp và không được là NULL',
                    'C' => 'Một bảng có thể chứa nhiều khóa chính',
                    'D' => 'Chỉ chấp nhận kiểu dữ liệu số nguyên (Integer)',
                ],
                'correct_answer' => 'B',
            ],
            [
                'question_text' => 'Lệnh SQL nào dùng để thay đổi cấu trúc của một bảng đã tồn tại?',
                'options' => [
                    'A' => 'UPDATE TABLE',
                    'B' => 'ALTER TABLE',
                    'C' => 'MODIFY TABLE',
                    'D' => 'CHANGE TABLE',
                ],
                'correct_answer' => 'B',
            ],
        ];

        foreach ($mcQuestions2 as $q) {
            Question::updateOrCreate(
                [
                    'exam_id' => $exam2->id,
                    'question_text' => $q['question_text'],
                ],
                [
                    'type' => 'multiple_choice',
                    'options' => $q['options'],
                    'correct_answer' => $q['correct_answer'],
                ]
            );
        }

        $essayQuestions2 = [
            [
                'question_text' => 'Trình bày khái niệm về Chuẩn hóa Cơ sở dữ liệu (Normalization). Nêu ngắn gọn điều kiện của Dạng chuẩn 1 (1NF), Dạng chuẩn 2 (2NF) và Dạng chuẩn 3 (3NF).',
            ],
        ];

        foreach ($essayQuestions2 as $q) {
            Question::updateOrCreate(
                [
                    'exam_id' => $exam2->id,
                    'question_text' => $q['question_text'],
                ],
                [
                    'type' => 'essay',
                    'options' => null,
                    'correct_answer' => null,
                ]
            );
        }

        // ---------------------------------------------------------
        // BÀI THI 3: Lập Trình Hướng Đối Tượng (OOP)
        // ---------------------------------------------------------
        $exam3 = Exam::updateOrCreate(
            ['title' => 'Kiểm Tra Lập Trình Hướng Đối Tượng (OOP)'],
            [
                'duration' => 60,
                'total_questions' => 6,
            ]
        );

        $mcQuestions3 = [
            [
                'question_text' => 'Tính chất nào của OOP cho phép che giấu dữ liệu bên trong lớp và chỉ cung cấp các phương thức truy cập ra bên ngoài?',
                'options' => [
                    'A' => 'Tính kế thừa (Inheritance)',
                    'B' => 'Tính đa hình (Polymorphism)',
                    'C' => 'Tính đóng gói (Encapsulation)',
                    'D' => 'Tính trừu tượng (Abstraction)',
                ],
                'correct_answer' => 'C',
            ],
            [
                'question_text' => 'Từ khóa nào được sử dụng trong PHP để một lớp con kế thừa từ một lớp cha?',
                'options' => [
                    'A' => 'implements',
                    'B' => 'extends',
                    'C' => 'inherits',
                    'D' => 'using',
                ],
                'correct_answer' => 'B',
            ],
            [
                'question_text' => 'Chỉ định truy cập (Access Modifier) nào cho phép các thuộc tính/phương thức được truy cập trong cùng một lớp và các lớp con kế thừa từ nó?',
                'options' => [
                    'A' => 'public',
                    'B' => 'private',
                    'C' => 'protected',
                    'D' => 'static',
                ],
                'correct_answer' => 'C',
            ],
            [
                'question_text' => 'Một Interface trong lập trình hướng đối tượng có đặc điểm gì?',
                'options' => [
                    'A' => 'Có thể khởi tạo đối tượng trực tiếp bằng từ khóa new',
                    'B' => 'Chỉ chứa các khai báo phương thức (chữ ký) mà không có phần thân xử lý',
                    'C' => 'Có thể chứa thuộc tính biến thông thường như class',
                    'D' => 'Một lớp chỉ có thể implements tối đa 1 interface',
                ],
                'correct_answer' => 'B',
            ],
        ];

        foreach ($mcQuestions3 as $q) {
            Question::updateOrCreate(
                [
                    'exam_id' => $exam3->id,
                    'question_text' => $q['question_text'],
                ],
                [
                    'type' => 'multiple_choice',
                    'options' => $q['options'],
                    'correct_answer' => $q['correct_answer'],
                ]
            );
        }

        $essayQuestions3 = [
            [
                'question_text' => 'Giải thích khái niệm Đa hình (Polymorphism) và cho ví dụ minh họa bằng code PHP.',
            ],
            [
                'question_text' => 'Tóm tắt ngắn gọn 5 nguyên lý thiết kế phần mềm SOLID trong lập trình hướng đối tượng.',
            ],
        ];

        foreach ($essayQuestions3 as $q) {
            Question::updateOrCreate(
                [
                    'exam_id' => $exam3->id,
                    'question_text' => $q['question_text'],
                ],
                [
                    'type' => 'essay',
                    'options' => null,
                    'correct_answer' => null,
                ]
            );
        }
    }
}
