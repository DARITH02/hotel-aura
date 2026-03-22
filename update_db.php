<?php
require 'config/database.php';
$db = (new Database())->conn;
try {
    // Check if access_key exists
    $stmt = $db->query("SHOW COLUMNS FROM admins LIKE 'access_key'");
    if (!$stmt->fetch()) {
        $db->exec("ALTER TABLE admins ADD COLUMN access_key VARCHAR(255) DEFAULT NULL");
        echo "Column 'access_key' added to 'admins' table." . PHP_EOL;
    } else {
        echo "Column 'access_key' already exists." . PHP_EOL;
    }
} catch (PDOException $e) {
    echo "Error updating database: " . $e->getMessage() . PHP_EOL;
}
