<?php
include "connection.php";

if (isset($_GET['borrowId'])) {
    $borrowId = $_GET['borrowId'];
    $sql = "DELETE FROM borrow WHERE borrowId = :borrowId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':borrowId', $borrowId);
    $stmt->execute();

    echo '<script>alert("Record deleted successfully!"); window.location="borrowbook.php";</script>';
} else {
    echo '<script>alert("Invalid request!"); window.location="borrowbook.php";</script>';
}
?>
