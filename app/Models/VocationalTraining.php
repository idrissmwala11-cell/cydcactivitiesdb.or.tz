<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VocationalTraining extends Model
{
    protected $table = 'vocational_training';
    
    protected $fillable = [
        'student_name',
        'school_name',
        'skill_category',
        'training_level',
        'user_id'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
