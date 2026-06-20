<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasomoYaFani extends Model
{
    protected $table = 'masomo_ya_fani';

    protected $fillable = [
        'user_id',
        'date',
        'teacher',
        'fani_type',
        'topic',
        'student_preferences',
        'student_feedback',
        'teacher_feedback',
        'present_participants',
        'absent_participants',
        'present_count',
        'absent_count',
        'status',
        'admin_notes',
        'submitted_at',
    ];

    protected $casts = [
        'date' => 'date',
        'submitted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
