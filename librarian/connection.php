<?php
try {
    // Create a new PDO connection
    $conn = new PDO('mysql:host=localhost;dbname=lb1', 'root', '');
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection failure
    die('Connection failed: ' . $e->getMessage());
}
?>
    
