<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->string('education_level');
            $table->string('student_name');
            $table->string('school_name');
            $table->string('class_level');
            $table->string('exam_type');
            $table->unsignedSmallInteger('exam_year');
            $table->string('performance')->nullable();
            $table->string('gpa')->nullable();
            $table->text('best_subjects')->nullable();
            $table->text('failed_subjects')->nullable();
            $table->text('comments')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['education_level', 'user_id']);
        });

        if (! Schema::hasTable('submissions')) {
            return;
        }

        $map = [
            'exam_primary' => 'primary',
            'exam_secondary' => 'secondary',
            'exam_a_level' => 'a-level',
            'exam_college' => 'college',
            'exam_university' => 'university',
        ];

        DB::table('submissions')
            ->whereIn('section_type', array_keys($map))
            ->orderBy('id')
            ->chunkById(100, function ($rows) use ($map) {
                foreach ($rows as $row) {
                    $data = json_decode($row->form_data ?? '[]', true);

                    if (! is_array($data)) {
                        $data = [];
                    }

                    DB::table('exam_results')->insert([
                        'education_level' => $map[$row->section_type] ?? 'primary',
                        'student_name' => (string) ($data['student_name'] ?? 'N/A'),
                        'school_name' => (string) ($data['school_name'] ?? 'N/A'),
                        'class_level' => (string) ($data['class_level'] ?? 'N/A'),
                        'exam_type' => (string) ($data['exam_type'] ?? 'N/A'),
                        'exam_year' => (int) ($data['exam_year'] ?? now()->year),
                        'performance' => $data['performance'] ?? null,
                        'gpa' => $data['gpa'] ?? null,
                        'best_subjects' => $data['best_subjects'] ?? null,
                        'failed_subjects' => $data['failed_subjects'] ?? null,
                        'comments' => $data['comments'] ?? null,
                        'user_id' => $row->user_id,
                        'created_at' => $row->created_at ? Carbon::parse($row->created_at) : now(),
                        'updated_at' => $row->updated_at ? Carbon::parse($row->updated_at) : now(),
                    ]);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
