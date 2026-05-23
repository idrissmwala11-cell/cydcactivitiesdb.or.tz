<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamResult extends Model
{
    protected $fillable = [
        'education_level',
        'student_name',
        'school_name',
        'class_level',
        'exam_type',
        'exam_year',
        'performance',
        'gpa',
        'best_subjects',
        'failed_subjects',
        'comments',
        'user_id',
    ];

    protected $casts = [
        'exam_year' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
