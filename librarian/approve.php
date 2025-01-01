<?php
include "connection.php";

// Validate and sanitize the input
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = intval($_GET["id"]);

    try {
        // Prepare the SQL statement to update the status
        $stmt = $conn->prepare("UPDATE student_registration SET status = 'yes' WHERE id = :id");
        // Bind the parameter to the prepared statement
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the display page after successful update
            echo '<script type="text/javascript">
                      window.location = "display_student_info.php";
                  </script>';
        } else {
            echo "Error updating record.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid ID.";
}
?>
