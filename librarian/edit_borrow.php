<?php
include "connection.php";
include "header.php";

if (isset($_GET['borrowId'])) {
    $borrowId = $_GET['borrowId'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Update the record
        $sql = "UPDATE borrow SET student_name = :student_name, book_name = :book_name, borrow_Date = :borrow_Date, 
                return_Date = :return_Date, fine = :fine WHERE borrowId = :borrowId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':student_name', $_POST['student_name']);
        $stmt->bindParam(':book_name', $_POST['book_name']);
        $stmt->bindParam(':borrow_Date', $_POST['borrow_Date']);
        $stmt->bindParam(':return_Date', $_POST['return_Date']);
        $stmt->bindParam(':fine', $_POST['fine']);
        $stmt->bindParam(':borrowId', $borrowId);
        $stmt->execute();

        echo '<script>alert("Record updated successfully!"); window.location="borrowbook.php";</script>';
    } else {
        // Fetch the record
        $sql = "SELECT * FROM borrow WHERE borrowId = :borrowId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':borrowId', $borrowId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} else {
    echo '<script>alert("Invalid request!"); window.location="borrowbook.php";</script>';
    exit;
}
?>
<form method="post">
    <label>Student Name:</label>
    <input type="text" name="student_name" value="<?php echo htmlspecialchars($result['student_name']); ?>" required>
    <label>Book Name:</label>
    <input type="text" name="book_name" value="<?php echo htmlspecialchars($result['book_name']); ?>" required>
    <label>Borrow Date:</label>
    <input type="date" name="borrow_Date" value="<?php echo htmlspecialchars($result['borrow_Date']); ?>" required>
    <label>Return Date:</label>
    <input type="date" name="return_Date" value="<?php echo htmlspecialchars($result['return_Date']); ?>" required>
    <label>Fine:</label>
    <input type="text" name="fine" value="<?php echo htmlspecialchars($result['fine']); ?>" required>
    <button type="submit">Update</button>
</form>
