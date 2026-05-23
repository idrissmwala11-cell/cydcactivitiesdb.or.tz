<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TalentAbsentParticipant extends Model
{
    protected $table = 'talent_absent_participants';

    protected $fillable = [
        'attendance_id',
        'participant_name',
        'participant_number',
        'status',
        'user_id',
    ];

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(TalentAttendance::class, 'attendance_id');
    }
}