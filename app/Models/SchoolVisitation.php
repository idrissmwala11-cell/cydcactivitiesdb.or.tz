<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolVisitation extends Model
{
    protected $fillable = [
        'participant_name',
        'registration_number',
        'school_name',
        'class_level',
        'participant_presence',
        'academic_progress',
        'academic_challenges',
        'discipline_status',
        'bad_behaviors',
        'cleanliness_status',
        'teacher_comments',
        'visitor_comments',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
