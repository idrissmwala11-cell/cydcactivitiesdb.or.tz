<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing database tables for search functionality:\n";
echo "================================================\n";

// Test ParentsInformation
try {
    $count = \App\Models\ParentsInformation::count();
    echo "✓ ParentsInformation table exists - Records: $count\n";
    
    // Test search query
    $results = \App\Models\ParentsInformation::where('parent_name', 'LIKE', '%test%')->get();
    echo "  Search test: Found " . $results->count() . " results\n";
} catch (Exception $e) {
    echo "✗ ParentsInformation error: " . $e->getMessage() . "\n";
}

// Test CenterLeadership
try {
    $count = \App\Models\CenterLeadership::count();
    echo "✓ CenterLeadership table exists - Records: $count\n";
    
    // Test search query
    $results = \App\Models\CenterLeadership::where('center_name', 'LIKE', '%test%')->get();
    echo "  Search test: Found " . $results->count() . " results\n";
} catch (Exception $e) {
    echo "✗ CenterLeadership error: " . $e->getMessage() . "\n";
}

// Test SpecialProgram
try {
    $count = \App\Models\SpecialProgram::count();
    echo "✓ SpecialProgram table exists - Records: $count\n";
    
    // Test search query
    $results = \App\Models\SpecialProgram::where('topic', 'LIKE', '%test%')->get();
    echo "  Search test: Found " . $results->count() . " results\n";
} catch (Exception $e) {
    echo "✗ SpecialProgram error: " . $e->getMessage() . "\n";
}

echo "\nTesting search controller method:\n";
echo "==================================\n";

try {
    // Simulate the search functionality
    $query = 'test';
    $results = [];
    
    // Search Parents Information
    $parentsInfo = \App\Models\ParentsInformation::with('user')
        ->where(function($q) use ($query) {
            $q->where('parent_name', 'LIKE', "%{$query}%")
              ->orWhere('parent_of', 'LIKE', "%{$query}%")
              ->orWhere('activity', 'LIKE', "%{$query}%")
              ->orWhere('support_type', 'LIKE', "%{$query}%");
        })
        ->get();
    
    echo "✓ ParentsInformation search query works - Found: " . $parentsInfo->count() . " results\n";
    
    // Search Center Leadership
    $centerLeadership = \App\Models\CenterLeadership::with('user')
        ->where(function($q) use ($query) {
            $q->where('center_name', 'LIKE', "%{$query}%")
              ->orWhere('leadership_list', 'LIKE', "%{$query}%")
              ->orWhere('challenges', 'LIKE', "%{$query}%")
              ->orWhere('feedback', 'LIKE', "%{$query}%");
        })
        ->get();
    
    echo "✓ CenterLeadership search query works - Found: " . $centerLeadership->count() . " results\n";
    
    // Search Special Programs
    $specialPrograms = \App\Models\SpecialProgram::with('user')
        ->where(function($q) use ($query) {
            $q->where('topic', 'LIKE', "%{$query}%")
              ->orWhere('teacher', 'LIKE', "%{$query}%")
              ->orWhere('age_range', 'LIKE', "%{$query}%")
              ->orWhere('teacher_feedback', 'LIKE', "%{$query}%")
              ->orWhere('supervisor_feedback', 'LIKE', "%{$query}%");
        })
        ->get();
    
    echo "✓ SpecialProgram search query works - Found: " . $specialPrograms->count() . " results\n";
    
    $totalResults = $parentsInfo->count() + $centerLeadership->count() + $specialPrograms->count();
    echo "\n✓ Total search results: $totalResults\n";
    
} catch (Exception $e) {
    echo "✗ Search controller simulation error: " . $e->getMessage() . "\n";
}

echo "\nDone!\n";