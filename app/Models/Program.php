<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date'
    ];

    public static function count()
    {
        // Count distinct talent types as programs
        return \DB::table('talents_information')
            ->distinct()
            ->count('talent_type');
    }
}