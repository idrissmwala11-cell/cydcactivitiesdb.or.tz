<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OutOfMinistryLeaderDetail extends Model
{
    protected $table = 'out_of_ministry_leader_details';
    
    protected $fillable = [
        'out_of_ministry_leader_id',
        'leader_name',
        'position',
        'gender'
    ];
    
    public function outOfMinistryLeader(): BelongsTo
    {
        return $this->belongsTo(OutOfMinistryLeader::class);
    }
}