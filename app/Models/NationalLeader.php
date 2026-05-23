<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NationalLeader extends Model
{
    protected $table = 'national_leaders';
    
    protected $fillable = [
        'center',
        'term_end',
        'challenges',
        'comments',
        'user_id'
    ];
    
    protected $casts = [
        'term_end' => 'date'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function nationalLeaderDetails(): HasMany
    {
        return $this->hasMany(NationalLeaderDetail::class, 'leader_id');
    }
}