<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasomoYaMtaala extends Model
{
    protected $table = 'masomo_ya_mtaala';

    protected $fillable = [
        'user_id',
        'status',
        'date',
        'teacher',
        'subject_type',
        'age_group',
        'topic',
        'category',
        'student_feedback',
        'teacher_feedback',
        'present_participants',
        'absent_participants',
    ];

    protected $casts = [
        'date' => 'date',
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match (strtolower((string) $this->category)) {
            'kiroho', 'spiritual' => 'Spiritual',
            'kimwili', 'physical' => 'Physical',
            'kiakili', 'mental' => 'Mental',
            'kijamii', 'social' => 'Social',
            default => 'N/A',
        };
    }

    public function getCurrentCategoryAttribute(): ?string
    {
        return match (strtolower((string) $this->category)) {
            'kiroho', 'spiritual' => 'kiroho',
            'kimwili', 'physical' => 'kimwili',
            'kiakili', 'mental' => 'kiakili',
            'kijamii', 'social' => 'kijamii',
            default => null,
        };
    }
}
