<?php
require_once 'app/config/config.php';
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "--- Table: room_types ---\n";
    $cols = $db->query("DESCRIBE room_types")->fetchAll(PDO::FETCH_ASSOC);
    foreach($cols as $c) print_r($c);
    
    echo "\n--- Data: room_types ---\n";
    $data = $db->query("SELECT * FROM room_types")->fetchAll(PDO::FETCH_ASSOC);
    foreach($data as $d) print_r($d);
    
    echo "\n--- Table: room_type_images ---\n";
    $cols2 = $db->query("DESCRIBE room_type_images")->fetchAll(PDO::FETCH_ASSOC);
    foreach($cols2 as $c) print_r($c);
    
    echo "\n--- Data: room_type_images ---\n";
    $data2 = $db->query("SELECT * FROM room_type_images")->fetchAll(PDO::FETCH_ASSOC);
    foreach($data2 as $d) print_r($d);

} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
