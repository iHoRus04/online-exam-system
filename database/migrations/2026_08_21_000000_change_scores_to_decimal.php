<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        try {
            if (DB::getDriverName() === 'pgsql') {
                DB::statement('ALTER TABLE exam_results ALTER COLUMN total_score TYPE NUMERIC(8,2);');
                DB::statement('ALTER TABLE student_answers ALTER COLUMN score TYPE NUMERIC(8,2);');
            } else {
                DB::statement('ALTER TABLE exam_results MODIFY total_score DECIMAL(8,2) DEFAULT 0;');
                DB::statement('ALTER TABLE student_answers MODIFY score DECIMAL(8,2) NULL;');
            }
        } catch (\Exception $e) {
            // Ignore if column is already numeric or table re-created
        }
    }

    public function down(): void
    {
        try {
            if (DB::getDriverName() === 'pgsql') {
                DB::statement('ALTER TABLE exam_results ALTER COLUMN total_score TYPE INTEGER;');
                DB::statement('ALTER TABLE student_answers ALTER COLUMN score TYPE INTEGER;');
            }
        } catch (\Exception $e) {
            // Ignore
        }
    }
};
