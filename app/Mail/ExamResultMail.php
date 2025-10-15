<?php

namespace App\Mail;

use App\Models\ExamResult;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExamResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $result;

    public function __construct(ExamResult $result)
    {
        $this->result = $result;
    }

    public function build()
    {
        return $this->subject('Kết quả bài thi: ' . $this->result->exam->title)
                    ->view('emails.exam_result');
    }
}
