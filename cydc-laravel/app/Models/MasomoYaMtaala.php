<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasomoYaMtaala extends Model
{
    protected $table = 'masomo_ya_mtaala';
    
    protected $fillable = [
        'user_id',
        'tarehe',
        'jina_la_mwalimu',
        'somo_analofundisha',
        'kiroho',
        'kimwili',
        'kiakili',
        'kijamii',
        'darasa_la_mjaka_mingapi',
        'mada_aliyo_fundisha',
        'maoni_ya_mwanafunzi',
        'maoni_ya_mwalimu',
        'status',
        'admin_notes',
        'submitted_at'
    ];
    
    protected $casts = [
        'tarehe' => 'date',
        'submitted_at' => 'datetime',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
