<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillsAttendance extends Model
{
    protected $table = 'skills_attendance';
    
    protected $fillable = [
        'date',
        'teacher_name',
        'lesson_topic',
        'present_count',
        'teacher_comments',
        'supervisor_comments',
        'lesson_topic_details',
        'user_id'
    ];
    
    protected $casts = [
        'date' => 'date',
        'present_count' => 'integer',
        'user_id' => 'integer',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function absentParticipants(): HasMany
    {
        return $this->hasMany(AbsentParticipant::class, 'attendance_id');
    }

    public function getAbsentCountAttribute(): int
    {
        return $this->absentParticipants()->where('status', 'absent')->count();
    }

    public function getTotalParticipantsCountAttribute(): int
    {
        return $this->present_count + $this->absent_count;
    }
}
