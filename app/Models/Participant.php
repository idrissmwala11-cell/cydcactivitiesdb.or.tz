<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'talents_information'; // Using existing table
    
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}