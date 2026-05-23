<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=cydc_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Base Leaders Table Structure:\n";
    $stmt = $pdo->query('DESCRIBE base_leaders');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . ' - ' . $row['Type'] . "\n";
    }
    
    echo "\nNational Leader Details Table Structure:\n";
    $stmt = $pdo->query('DESCRIBE national_leader_details');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . ' - ' . $row['Type'] . "\n";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>