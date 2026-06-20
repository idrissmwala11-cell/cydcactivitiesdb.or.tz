<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialProgram extends Model
{
    protected $table = 'special_programs';

    protected $fillable = [
        'date',
        'teacher',
        'topic',
        'age_range',
        'teacher_feedback',
        'supervisor_feedback',
        'present_participants',
        'absent_participants',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
        'user_id' => 'integer', // 🔥 FIX YA 403 ISSUE
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
