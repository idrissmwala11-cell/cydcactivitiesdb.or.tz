<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocalSponsorship extends Model
{
    protected $fillable = [
        'child_name',
        'child_age',
        'child_location',
        'sponsor_type',
        'sponsor_name',
        'local_number',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
