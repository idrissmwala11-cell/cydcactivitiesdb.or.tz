<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'instructor_id',
        'program_id'
    ];

    public static function count()
    {
        // Count total sessions from both attendance tables
        $talentSessions = \DB::table('talent_attendance')->count();
        $skillsSessions = \DB::table('skills_attendance')->count();
        
        return $talentSessions + $skillsSessions;
    }

    public static function recent($limit = 5)
    {
        // Return recent sessions from talent_attendance
        return \DB::table('talent_attendance')
            ->select('lesson_topic as title', 'date', 'instructor_name as instructor')
            ->orderBy('date', 'desc')
            ->limit($limit)
            ->get();
    }
}