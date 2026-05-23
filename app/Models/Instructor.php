<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    // This will be a virtual model since there's no dedicated instructors table
    // We'll use data from talent_attendance and skills_attendance tables
    protected $fillable = [
        'name',
        'email',
        'phone'
    ];

    public static function count()
    {
        // Count unique instructors from both attendance tables
        $talentInstructors = \DB::table('talent_attendance')
            ->distinct()
            ->count('instructor_name');
        
        $skillsInstructors = \DB::table('skills_attendance')
            ->distinct()
            ->count('teacher_name');
            
        return $talentInstructors + $skillsInstructors;
    }
}