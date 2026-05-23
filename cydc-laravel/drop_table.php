<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=cydc_db', 'root', '');
    $pdo->exec('DROP TABLE IF EXISTS absent_participants');
    echo "Table 'absent_participants' dropped successfully\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>