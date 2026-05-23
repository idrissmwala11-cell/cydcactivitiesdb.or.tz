<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BaseLeader extends Model
{
    protected $table = 'base_leaders';
    
    protected $fillable = [
        'base_name',
        'leaders_count',
        'meeting_count',
        'term_end',
        'additional_notes',
        'user_id'
    ];
    
    public function baseLeaderDetails()
    {
        return $this->hasMany(BaseLeaderDetail::class, 'base_id');
    }
    
    protected $casts = [
        'term_end' => 'date',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    

}
