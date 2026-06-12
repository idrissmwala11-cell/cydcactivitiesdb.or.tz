<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BaseLeaderDetail extends Model
{
    protected $table = 'base_leader_details';
    
    protected $fillable = [
        'base_id',
        'leader_number',
        'leader_name',
        'leader_id',
        'leader_position'
    ];
    
    public function baseLeader(): BelongsTo
    {
        return $this->belongsTo(BaseLeader::class, 'base_id');
    }
}