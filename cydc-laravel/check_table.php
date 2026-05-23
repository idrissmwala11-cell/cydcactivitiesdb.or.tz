<?php

require_once 'vendor/autoload.php';

// Load Laravel configuration
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Get database connection
    $pdo = DB::connection()->getPdo();
    
    // Check if table exists and get its structure
    $stmt = $pdo->prepare("DESCRIBE masomo_ya_fani");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Table structure for masomo_ya_fani:\n";
    echo "=====================================\n";
    
    foreach ($columns as $column) {
        echo "Column: {$column['Field']} | Type: {$column['Type']} | Null: {$column['Null']} | Default: {$column['Default']}\n";
    }
    
    // Check specifically for status column
    $hasStatus = false;
    foreach ($columns as $column) {
        if ($column['Field'] === 'status') {
            $hasStatus = true;
            break;
        }
    }
    
    echo "\n";
    echo "Status column exists: " . ($hasStatus ? 'YES' : 'NO') . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}