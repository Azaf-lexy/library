<?php
include "connection.php";
include "header.php"; 
// Check if connection is successful
if (!$conn) {
    die("Connection failed: Please try again later.");
}

try {
    // Fetch data from 'borrow' table
    if ($role == 'admin') {
        $sql = "SELECT * FROM borrow";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        // Fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Ensure `getAttribute` function is defined or replace with valid retrieval logic
        $student_name = getAttribute("student_username"); // Replace this with actual logic to get the username
    
        // Call the function and store results
        $results = borrow_student($student_name);
    }
   
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Update logic when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editBorrowId'])) {
    $borrowId = $_POST['editBorrowId'];
    $returnDate = $_POST['editReturnDate'];
    $due_date = $_POST['due_date'];

    try {
        $updateSql = "UPDATE borrow 
SET  
    return_Date = :return_Date,
    fine = CASE 
              WHEN :return_Date IS NOT NULL AND :return_Date != '0000-00-00 00:00:00' AND :return_Date > due_date 
              THEN DATEDIFF(:return_Date, due_date) * 20
              ELSE fine
           END
WHERE borrowId = :borrowId";

        $updateStmt = $conn->prepare($updateSql);
      
        $updateStmt->bindParam(':return_Date', $returnDate);
        $updateStmt->bindParam(':due_date', $due_date);
        $updateStmt->bindParam(':borrowId', $borrowId);
        $updateStmt->execute();
        
        echo '<script>alert("Record updated successfully!"); window.location="borrowbook.php";</script>';
    } catch (PDOException $e) {
        echo "Error updating record: " . $e->getMessage();
    }
}
?>

<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3>Borrow Book Details</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row" style="min-height:500px">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Borrow Book</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student Name</th>
                                <th>Book Name</th>
                                <th>Borrowed Date</th>
                                <th>Due Date</th>
                                <th>Return Date</th>
                                <th>Fine</th>
                                <?php if ($role   == 'admin') : ?>
                                <th>Actions</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                  if ($results) {
                    foreach ($results as $value) {
                        echo '<tr>
                                <td>' . htmlspecialchars($value['borrowId']) . '</td>
                                <td>' . htmlspecialchars($value['student_name']) . '</td>
                                <td>' . htmlspecialchars($value['book_name']) . '</td>
                                <td>' . htmlspecialchars($value['borrow_Date']) . '</td>
                                <td>' . htmlspecialchars($value['due_date']) . '</td>
                                <td>' . htmlspecialchars($value['return_Date']) . '</td>
                                <td>' . htmlspecialchars($value['fine']) . '</td>';
                                
                        // Admin-specific actions
                        if ($role == 'admin') {
                            echo '<td>
                                    <button class="btn btn-warning btn-sm" onclick="openEditModal(' . htmlspecialchars(json_encode($value)) . ')">Edit</button>
                                    <a href="delete_borrow.php?borrowId=' . $value['borrowId'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this record?\')">Delete</a>
                                  </td>';
                        }
                
                        echo '</tr>';
                    }
                }
                
                              
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="editForm">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Borrow Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="editBorrowId" id="editBorrowId">
                    <div class="form-group">
                        <label for="editStudentName">Student Name</label>
                        <input type="text" name="editStudentName" id="editStudentName" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="editBookName">Book Name</label>
                        <input type="text" name="editBookName" id="editBookName" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="editBorrowDate">Borrow Date</label>
                        <input type="date" name="editBorrowDate" id="editBorrowDate" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="editduedate">Due Date</label>
                        <input type="date" name="editduedate" id="editduedate" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="editReturnDate">Return Date</label>
                        <input type="date" name="editReturnDate" id="editReturnDate" class="form-control" required>
                    </div>
                  
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(data) {
    
    document.getElementById('editBorrowId').value = data.borrowId;
    document.getElementById('editStudentName').value = data.student_name;
    document.getElementById('editBookName').value = data.book_name;
    document.getElementById('editBorrowDate').value = data.borrow_Date;
    document.getElementById('editduedate').value = data.due_date;
    document.getElementById('editReturnDate').value = data.return_Date;
   
    // Show the modal
    $('#editModal').modal('show');
}
</script>

<?php
include "footer.php";
?>
