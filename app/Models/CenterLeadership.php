<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CenterLeadership extends Model
{
    protected $table = 'center_leadership';
    
    protected $fillable = [
        'center_name',
        'leadership_list',
        'challenges',
        'feedback',
        'status',
        'user_id'
    ];
    
    protected $casts = [
        'leadership_list' => 'array'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
