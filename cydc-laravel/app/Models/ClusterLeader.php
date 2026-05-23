<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClusterLeader extends Model
{
    protected $table = 'cluster_leaders';
    
    protected $fillable = [
        'cluster_name',
        'yds_name',
        'leader_count',
        'meeting_count',
        'gethro_practice',
        'leadership_term',
        'comments',
        'user_id'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function leaderDetails(): HasMany
    {
        return $this->hasMany(ClusterLeaderDetail::class, 'cluster_id');
    }
}