<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeVisitation extends Model
{
    protected $table = 'home_visitations';
    
    protected $fillable = [
        'jina',
        'namba',
        'shule',
        'darasa',
        'last_program',
        'likes_program',
        'participant_comments',
        'mtaa',
        'mazingira',
        'nyumba',
        'paa',
        'choo',
        'milo',
        'wanaume',
        'wanawake',
        'tabia',
        'visit_date',
        'maoni',
        'mtembelezaji',
        'nafasi',
        'user_id'
    ];
    
    protected $casts = [
        'visit_date' => 'date',
        'wanaume' => 'integer',
        'wanawake' => 'integer',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
