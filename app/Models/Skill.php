<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category'
    ];

    public static function count()
    {
        // Count distinct lesson topics as skills
        return \DB::table('skills_attendance')
            ->distinct()
            ->count('lesson_topic');
    }
}