<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    echo "MySQL connection successful\n";
    
    // Try to connect to the specific database
    $pdo_db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=cydc_db', 'root', '');
    echo "Database 'cydc_db' connection successful\n";
    
} catch (Exception $e) {
    echo "MySQL connection failed: " . $e->getMessage() . "\n";
}
?>