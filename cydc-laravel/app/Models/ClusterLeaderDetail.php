<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClusterLeaderDetail extends Model
{
    protected $table = 'cluster_leader_details';
    
    protected $fillable = [
        'cluster_id',
        'leader_name',
        'leader_id',
        'leader_position',
        'user_id'
    ];
    
    public function clusterLeader(): BelongsTo
    {
        return $this->belongsTo(ClusterLeader::class, 'cluster_id');
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}