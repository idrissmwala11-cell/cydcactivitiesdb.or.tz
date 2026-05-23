<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TalentAttendance extends Model
{
    protected $table = 'talent_attendance';
    
    protected $fillable = [
        'date',
        'instructor_name',
        'talent_taught',
        'attendance_count',
        'instructor_comments',
        'supervisor_comments',
        'lesson_topic',
        'user_id'
    ];
    
    protected $casts = [
        'date' => 'date',
        'attendance_count' => 'integer',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function absentParticipants(): HasMany
    {
        return $this->hasMany(TalentAbsentParticipant::class, 'attendance_id');
    }
}
