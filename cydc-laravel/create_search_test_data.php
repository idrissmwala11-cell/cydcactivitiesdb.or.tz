<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Creating test data for search functionality:\n";
echo "============================================\n";

// Get a test user
$user = \App\Models\User::where('email', 'user@cydc.com')->first();
if (!$user) {
    echo "✗ Test user not found. Please run database seeder first.\n";
    exit(1);
}

echo "Using test user: {$user->email} (ID: {$user->id})\n\n";

// Create ParentsInformation test data
try {
    $parentsInfo = \App\Models\ParentsInformation::create([
        'parent_name' => 'John Test Parent',
        'parent_of' => 'Mary Test Child',
        'activity' => 'Test Activity Program',
        'support_type' => 'Educational Support',
        'address' => '123 Test Street',
        'parent_comments' => 'This is a test comment for search',
        'supervisor_comments' => 'Supervisor test feedback',
        'submission_date' => now(),
        'user_id' => $user->id,
        'status' => 'pending'
    ]);
    echo "✓ Created ParentsInformation test record (ID: {$parentsInfo->id})\n";
} catch (Exception $e) {
    echo "✗ ParentsInformation creation error: " . $e->getMessage() . "\n";
}

// Create CenterLeadership test data
try {
    $centerLeadership = \App\Models\CenterLeadership::create([
        'center_name' => 'Test Community Center',
        'leadership_list' => 'John Test Leader, Mary Test Assistant',
        'challenges' => 'Test challenges in community development',
        'feedback' => 'Test feedback from leadership team',
        'status' => 'pending',
        'user_id' => $user->id
    ]);
    echo "✓ Created CenterLeadership test record (ID: {$centerLeadership->id})\n";
} catch (Exception $e) {
    echo "✗ CenterLeadership creation error: " . $e->getMessage() . "\n";
}

// Create SpecialProgram test data
try {
    $specialProgram = \App\Models\SpecialProgram::create([
        'date' => now(),
        'teacher' => 'Test Teacher Name',
        'topic' => 'Test Educational Topic',
        'age_range' => '10-15 years',
        'teacher_feedback' => 'Test teacher feedback content',
        'supervisor_feedback' => 'Test supervisor feedback content',
        'user_id' => $user->id
    ]);
    echo "✓ Created SpecialProgram test record (ID: {$specialProgram->id})\n";
} catch (Exception $e) {
    echo "✗ SpecialProgram creation error: " . $e->getMessage() . "\n";
}

echo "\nTest data creation completed!\n";
echo "You can now search for 'test' to find these records.\n";