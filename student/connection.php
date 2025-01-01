<?php
try {
    $conn = new PDO('mysql:host=localhost;dbname=lms', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
include 'includes/function.php';
