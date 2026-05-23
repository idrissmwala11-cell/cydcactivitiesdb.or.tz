<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Abscent extends Model
{
    protected $table = 'abscent';
    
    protected $fillable = [
        'attendance_id',
        'jina_la_mshiriki',
        'namba_ya_mshiriki'
    ];
    
    public function curriculumAttendance(): BelongsTo
    {
        return $this->belongsTo(CurriculumAttendance::class, 'attendance_id');
    }
}
