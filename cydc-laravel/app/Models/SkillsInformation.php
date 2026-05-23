<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillsInformation extends Model
{
    protected $table = 'skills_information';
    
    protected $fillable = [
        'student_name',
        'gender',
        'student_id',
        'skill_category',
        'specific_skills',
        'skills_type',
        'group_skills_details',
        'skill_level',
        'has_certification',
        'certification_details',
        'mentor',
        'challenges',
        'support_received',
        'comments',
        'user_id'
    ];
    
    protected $casts = [
        'training_duration' => 'integer',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
