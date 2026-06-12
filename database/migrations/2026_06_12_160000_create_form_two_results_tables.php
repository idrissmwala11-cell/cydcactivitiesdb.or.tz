<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_two_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('name');
            $table->string('abbreviation', 20);
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('form_two_students', function (Blueprint $table) {
            $table->id();
            $table->string('student_number', 30)->unique();
            $table->string('candidate_name');
            $table->string('fcp_name')->nullable();
            $table->string('sex', 1);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('form_two_student_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('form_two_students')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('form_two_subjects')->cascadeOnDelete();
            $table->boolean('registered')->default(true);
            $table->unique(['student_id', 'subject_id']);
        });

        Schema::create('form_two_assessments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('term', 20)->default('TERM I');
            $table->date('assessment_date')->nullable();
            $table->decimal('max_marks', 5, 2)->default(100);
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });

        Schema::create('form_two_marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('form_two_assessments')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('form_two_students')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('form_two_subjects')->cascadeOnDelete();
            $table->decimal('mark', 5, 2)->nullable();
            $table->boolean('is_absent')->default(false);
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['assessment_id', 'student_id', 'subject_id'], 'form_two_mark_unique');
        });

        $now = now();
        DB::table('form_two_subjects')->insert([
            ['code' => '011', 'name' => 'CIVICS', 'abbreviation' => 'CIV', 'display_order' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '060', 'name' => 'HISTORIA YA TANZANIA', 'abbreviation' => 'HTM', 'display_order' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '012', 'name' => 'HISTORY', 'abbreviation' => 'HIST', 'display_order' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '013', 'name' => 'GEOGRAPHY', 'abbreviation' => 'GEO', 'display_order' => 4, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '021', 'name' => 'KISWAHILI', 'abbreviation' => 'KISW', 'display_order' => 5, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '022', 'name' => 'ENGLISH LANGUAGE', 'abbreviation' => 'ENGL', 'display_order' => 6, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '031', 'name' => 'PHYSICS', 'abbreviation' => 'PHY', 'display_order' => 7, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '032', 'name' => 'CHEMISTRY', 'abbreviation' => 'CHE', 'display_order' => 8, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '033', 'name' => 'BIOLOGY', 'abbreviation' => 'BIO', 'display_order' => 9, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '041', 'name' => 'BASIC MATHEMATICS', 'abbreviation' => 'B/MATH', 'display_order' => 10, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '037', 'name' => 'INFORMATION AND COMPUTER STUDIES', 'abbreviation' => 'ICS', 'display_order' => 11, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '063', 'name' => 'COMMERCE', 'abbreviation' => 'COMM', 'display_order' => 12, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '062', 'name' => 'BOOK KEEPING', 'abbreviation' => 'B/KP', 'display_order' => 13, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '014', 'name' => 'BIBLE KNOWLEDGE', 'abbreviation' => 'B/KNW', 'display_order' => 14, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => '024', 'name' => 'LITERATURE IN ENGLISH', 'abbreviation' => 'LIT-ENG', 'display_order' => 15, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('form_two_assessments')->insert([
            ['name' => 'January Monthly Test - 2026', 'slug' => 'january-2026', 'term' => 'TERM I', 'assessment_date' => '2026-01-31', 'max_marks' => 100, 'display_order' => 1, 'is_published' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'February Monthly Test - 2026', 'slug' => 'february-2026', 'term' => 'TERM I', 'assessment_date' => '2026-02-28', 'max_marks' => 100, 'display_order' => 2, 'is_published' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'March Monthly Test - 2026', 'slug' => 'march-2026', 'term' => 'TERM I', 'assessment_date' => '2026-03-31', 'max_marks' => 100, 'display_order' => 3, 'is_published' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'April Monthly Test - 2026', 'slug' => 'april-2026', 'term' => 'TERM I', 'assessment_date' => '2026-04-30', 'max_marks' => 100, 'display_order' => 4, 'is_published' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'May Monthly Test - 2026', 'slug' => 'may-2026', 'term' => 'TERM I', 'assessment_date' => '2026-05-31', 'max_marks' => 100, 'display_order' => 5, 'is_published' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Form Two Joint Examination - June 2026', 'slug' => 'joint-exam-june-2026', 'term' => 'TERM I', 'assessment_date' => '2026-06-30', 'max_marks' => 100, 'display_order' => 6, 'is_published' => false, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('form_two_marks');
        Schema::dropIfExists('form_two_assessments');
        Schema::dropIfExists('form_two_student_subject');
        Schema::dropIfExists('form_two_students');
        Schema::dropIfExists('form_two_subjects');
    }
};
