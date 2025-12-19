<?php
// Quick migration script: add 'exempt_ott' column to 'facture' table if it doesn't exist.
// Run from CLI: php scripts/add_exempt_ott_column.php

require_once __DIR__ . '/../model/connection.php';
$con = connection();
try {
    $check = $con->prepare("SHOW COLUMNS FROM `facture` LIKE 'exempt_ott'");
    $check->execute();
    if ($check->rowCount() === 0) {
        $con->exec("ALTER TABLE `facture` ADD COLUMN `exempt_ott` TINYINT(1) DEFAULT 0");
        echo "Column 'exempt_ott' added to 'facture'.\n";
    } else {
        echo "Column 'exempt_ott' already exists.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
