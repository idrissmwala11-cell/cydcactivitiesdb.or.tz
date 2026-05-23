<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParentsInformation extends Model
{
    protected $table = 'parents_information';
    
    protected $fillable = [
        'parent_name',
        'parent_of',
        'activity',
        'support_type',
        'address',
        'parent_comments',
        'supervisor_comments',
        'submission_date',
        'user_id'
    ];
    
    protected $casts = [
        'submission_date' => 'date',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    

}
