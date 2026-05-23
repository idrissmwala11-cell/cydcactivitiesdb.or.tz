<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurriculumAttendance extends Model
{
    use HasFactory;

    protected $table = 'curriculum_attendance';

    protected $fillable = [
        'tarehe',
        'jina_la_mwalimu',
        'somo',
        'wahudhuria',
        'maoni_ya_mwalimu',
        'maoni_ya_msimamizi',
        'mada',
        'user_id',
    ];

    protected $casts = [
        'tarehe' => 'date',
        'wahudhuria' => 'integer',
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(CurriculumAttendanceParticipant::class, 'curriculum_attendance_id');
    }

    public function getPresentCountAttribute(): int
    {
        return $this->participants()->where('status', 'present')->count();
    }

    public function getAbsentCountAttribute(): int
    {
        return $this->participants()->where('status', 'absent')->count();
    }
}