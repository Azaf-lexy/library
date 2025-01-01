<?php
include "connection.php";
include "header.php";

// Check if connection is successful
try {
    // Fetch data from 'borrow' table
    $sql = "SELECT * FROM borrow";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit; // Prevent further execution if there's an issue with the database
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
                                <th>Return Date</th>
                                <th>Fine</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($results)) {
                                foreach ($results as $value) {
                                    echo '<tr>
                                        <td>' . htmlspecialchars($value['borrowId']) . '</td>
                                        <td>' . htmlspecialchars($value['student_name']) . '</td>
                                        <td>' . htmlspecialchars($value['book_name']) . '</td>
                                        <td>' . htmlspecialchars($value['borrow_Date']) . '</td>
                                        <td>' . htmlspecialchars($value['return_Date']) . '</td>
                                        <td>' . htmlspecialchars($value['fine']) . '</td>
                                    </tr>';
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
