<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormTwoSubject extends Model
{
    protected $fillable = ['code', 'name', 'abbreviation', 'display_order', 'is_active', 'education_level'];

    protected $casts = ['is_active' => 'boolean'];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(FormTwoStudent::class, 'form_two_student_subject', 'subject_id', 'student_id')
            ->withPivot('registered');
    }

    public function marks(): HasMany
    {
        return $this->hasMany(FormTwoMark::class, 'subject_id');
    }
}
