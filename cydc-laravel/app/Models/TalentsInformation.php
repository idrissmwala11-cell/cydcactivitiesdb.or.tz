<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TalentsInformation extends Model
{
    protected $table = 'talents_information';
    
    protected $fillable = [
        'student_name',
        'participant_number',
        'age',
        'gender',
        'mentor',
        'talent_type',
        'talent_description',
        'talent_duration',
        'has_competed',
        'competition_details',
        'achievements',
        'needs_training',
        'training_details',
        'comments',
        'user_id'
    ];
    
    protected $casts = [
        'age' => 'integer',
        'has_competed' => 'boolean',
        'needs_training' => 'boolean',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
