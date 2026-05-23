<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'capacity'
    ];

    public static function count()
    {
        // Since there's no venues table, return a default count
        return 1; // Assuming one main venue
    }
}