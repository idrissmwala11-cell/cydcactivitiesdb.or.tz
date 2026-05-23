<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OutOfMinistryLeader extends Model
{
    protected $table = 'out_of_ministry_leaders';
    
    protected $fillable = [
        'leaders_count',
        'term_end',
        'user_id'
    ];
    
    public function outOfMinistryLeaderDetails()
    {
        return $this->hasMany(OutOfMinistryLeaderDetail::class);
    }
    
    protected $casts = [
        'term_end' => 'date'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}