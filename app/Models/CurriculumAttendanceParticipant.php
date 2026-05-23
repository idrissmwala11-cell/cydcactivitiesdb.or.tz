<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurriculumAttendanceParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_attendance_id',
        'participant_name',
        'participant_number',
        'status',
        'user_id',
    ];

    public function curriculumAttendance(): BelongsTo
    {
        return $this->belongsTo(CurriculumAttendance::class, 'curriculum_attendance_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}