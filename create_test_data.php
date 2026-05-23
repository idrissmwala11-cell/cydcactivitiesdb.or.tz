<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\SkillsAttendance;

// Get the test user
$user = User::where('email', 'user@cydc.com')->first();

if ($user) {
    // Create a test SkillsAttendance record
    $attendance = SkillsAttendance::create([
        'date' => '2024-01-15',
        'teacher_name' => 'John Doe',
        'lesson_topic' => 'Web Development',
        'present_count' => 25,
        'teacher_comments' => 'Good participation from students',
        'supervisor_comments' => 'Well organized session',
        'lesson_topic_details' => 'Introduction to HTML and CSS',
        'user_id' => $user->id
    ]);
    
    echo "Test SkillsAttendance record created with ID: " . $attendance->id . "\n";
    echo "User ID: " . $user->id . " (" . $user->email . ")\n";
    echo "User Role: " . $user->role . "\n";
} else {
    echo "Test user not found\n";
}