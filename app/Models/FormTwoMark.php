<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormTwoMark extends Model
{
    protected $fillable = ['assessment_id', 'student_id', 'subject_id', 'mark', 'is_absent', 'recorded_by'];

    protected $casts = [
        'mark' => 'decimal:2',
        'is_absent' => 'boolean',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(FormTwoAssessment::class, 'assessment_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(FormTwoStudent::class, 'student_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(FormTwoSubject::class, 'subject_id');
    }
}
