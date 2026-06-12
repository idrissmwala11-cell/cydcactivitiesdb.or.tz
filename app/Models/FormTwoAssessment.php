<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormTwoAssessment extends Model
{
    protected $fillable = ['name', 'slug', 'term', 'assessment_date', 'max_marks', 'display_order', 'is_published', 'education_level', 'class_level'];

    protected $casts = [
        'assessment_date' => 'date',
        'max_marks' => 'decimal:2',
        'is_published' => 'boolean',
    ];

    public function marks(): HasMany
    {
        return $this->hasMany(FormTwoMark::class, 'assessment_id');
    }
}
