<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=cydc_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== CYDC Database Analysis ===\n";
    
    // Get all tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Total tables found: " . count($tables) . "\n\n";
    
    // Separate Laravel tables from CYDC tables
    $laravelTables = ['cache', 'cache_locks', 'failed_jobs', 'job_batches', 'jobs', 'migrations', 'password_reset_tokens', 'sessions', 'users'];
    $cydcTables = array_diff($tables, $laravelTables);
    
    echo "Laravel tables: " . implode(', ', array_intersect($tables, $laravelTables)) . "\n\n";
    
    if (!empty($cydcTables)) {
        echo "CYDC-specific tables found: " . implode(', ', $cydcTables) . "\n\n";
        
        foreach ($cydcTables as $table) {
            echo "--- Table: $table ---\n";
            
            // Get table structure
            $stmt = $pdo->query("DESCRIBE $table");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($columns as $column) {
                echo sprintf("  %-25s %-20s %-5s %-5s %s\n", 
                    $column['Field'], 
                    $column['Type'], 
                    $column['Null'], 
                    $column['Key'], 
                    $column['Extra']
                );
            }
            
            // Get row count
            $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
            $count = $stmt->fetchColumn();
            echo "  Rows: $count\n\n";
        }
    } else {
        echo "No CYDC-specific tables found. Database appears to be fresh Laravel installation.\n";
        echo "\nBased on the PHP files analysis, we need to create these tables:\n";
        $expectedTables = [
            'talents_information',
            'skills_information', 
            'talent_attendance',
            'skills_attendance',
            'curriculum_attendance',
            'base_leaders',
            'cluster_leaders',
            'cydc_center_leaders',
            'home_visitations',
            'special_programs',
            'masomo_ya_mtaala',
            'saving_groups',
            'group_members',
            'parents_information',
            'college_info',
            'university_info',
            'vocational_training'
        ];
        
        foreach ($expectedTables as $table) {
            echo "  - $table\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>