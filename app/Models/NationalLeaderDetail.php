<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NationalLeaderDetail extends Model
{
    protected $table = 'national_leader_details';
    
    protected $fillable = [
        'leader_id',
        'leader_name',
        'participant_number',
        'position',
        'gender'
    ];
    
    public function nationalLeader(): BelongsTo
    {
        return $this->belongsTo(NationalLeader::class, 'leader_id');
    }
    

}