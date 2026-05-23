<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "Checking cluster_leaders table:\n";
    $result = DB::select('DESCRIBE cluster_leaders');
    foreach($result as $row) {
        echo $row->Field . ' - ' . $row->Type . ' - ' . $row->Null . ' - ' . $row->Key . ' - ' . $row->Default . "\n";
    }
} catch(Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    echo "Table might not exist. Let's check if it exists:\n";
    try {
        $tables = DB::select("SHOW TABLES LIKE 'cluster_leaders'");
        if (empty($tables)) {
            echo "cluster_leaders table does not exist.\n";
        } else {
            echo "cluster_leaders table exists but has issues.\n";
        }
    } catch(Exception $e2) {
        echo 'Error checking table existence: ' . $e2->getMessage() . "\n";
    }
}