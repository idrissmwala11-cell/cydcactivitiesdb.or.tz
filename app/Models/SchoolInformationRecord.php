<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolInformationRecord extends Model
{
    protected $fillable = [
        'education_level',
        'form_data',
        'user_id',
    ];

    protected $casts = [
        'form_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
