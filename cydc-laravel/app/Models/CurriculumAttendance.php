<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CurriculumAttendance extends Model
{
    protected $table = 'curriculum_attendance';
    
    protected $fillable = [
        'tarehe',
        'jina_la_mwalimu',
        'somo',
        'wahudhuria',
        'maoni_ya_mwalimu',
        'maoni_ya_msimamizi',
        'mada',
        'user_id'
    ];
    
    protected $casts = [
        'tarehe' => 'date',
        'wahudhuria' => 'integer',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function absentParticipants(): HasMany
    {
        return $this->hasMany(Abscent::class, 'attendance_id');
    }
}
