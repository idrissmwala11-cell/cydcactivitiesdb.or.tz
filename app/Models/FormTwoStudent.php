<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormTwoStudent extends Model
{
    protected $fillable = ['student_number', 'candidate_name', 'fcp_name', 'sex', 'education_level', 'class_level', 'is_active', 'created_by'];

    protected $casts = ['is_active' => 'boolean'];

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(FormTwoSubject::class, 'form_two_student_subject', 'student_id', 'subject_id')
            ->withPivot('registered')
            ->orderBy('display_order');
    }

    public function marks(): HasMany
    {
        return $this->hasMany(FormTwoMark::class, 'student_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
