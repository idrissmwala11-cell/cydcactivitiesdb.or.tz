<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SavingGroup extends Model
{
    protected $table = 'saving_groups';
    
    protected $fillable = [
        'group_name',
        'member_count',
        'group_mentor',
        'registration_status',
        'savings_level',
        'bank_account',
        'group_progress',
        'user_id'
    ];
    
    protected $casts = [
        'member_count' => 'integer',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function groupMembers(): HasMany
    {
        return $this->hasMany(GroupMember::class, 'group_id');
    }
}
