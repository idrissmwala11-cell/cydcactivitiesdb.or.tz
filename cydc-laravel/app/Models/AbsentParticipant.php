<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsentParticipant extends Model
{
    protected $table = 'absent_participants';
    
    protected $fillable = [
        'attendance_id',
        'participant_name',
        'participant_number',
        'user_id'
    ];
    
    public function skillsAttendance(): BelongsTo
    {
        return $this->belongsTo(SkillsAttendance::class, 'attendance_id');
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
