<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbsentParticipant extends Model
{
    use HasFactory;

    protected $table = 'absent_participants';

    protected $fillable = [
        'attendance_id',
        'attendance_type',
        'participant_name',
        'participant_number',
        'status',
        'user_id',
    ];

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(CurriculumAttendance::class, 'attendance_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}