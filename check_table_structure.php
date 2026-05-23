<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    // Check if table exists
    if (Schema::hasTable('national_leader_details')) {
        echo "Table 'national_leader_details' exists.\n";
        
        // Get table columns
        $columns = Schema::getColumnListing('national_leader_details');
        echo "Columns: " . implode(', ', $columns) . "\n";
        
        // Check specifically for gender column
        if (Schema::hasColumn('national_leader_details', 'gender')) {
            echo "Gender column exists.\n";
        } else {
            echo "Gender column does NOT exist.\n";
        }
    } else {
        echo "Table 'national_leader_details' does NOT exist.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}