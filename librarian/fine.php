<?php
include "connection.php";
include "header.php";


?>

<!-- Page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Fine Calculation</h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row" style="min-height:500px">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Fine Calculation Info</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?php
                        try {
                            // Update book status and fines
                            $query = ("UPDATE borrow
SET 
    fine = CASE 
        WHEN return_Date IS NOT NULL AND return_Date > due_date THEN DATEDIFF(return_Date, due_date) * 20
        WHEN due_date < CURDATE() AND (return_Date IS NULL OR return_Date = '0000-00-00') THEN DATEDIFF(CURDATE(), due_date) * 20
        ELSE fine
    END
WHERE due_date IS NOT NULL;");

                            $conn->exec($query);

                            // Fetch updated book records
                            $stmt = $conn->query("
                            SELECT borrowId, student_name, book_name, due_date, return_Date, borrow_Status, fine
                            FROM borrow
                            ORDER BY due_date DESC
                            ");

                            echo "<table class='table table-bordered'>";
                            echo "<tr>
                                <th>Student Name</th>
                                <th>Book Name</th>
                                <th>Due Date</th>
                                <th>Returned At</th>
                                <th>Book Status</th>
                                <th>Fine (LKR)</th>
                            </tr>";

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['book_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['due_date']) . "</td>";
                                echo "<td>" . ($row['return_Date'] !== null ? htmlspecialchars($row['return_Date']) : 'Not Returned') . "</td>";
                                echo "<td>" . htmlspecialchars($row['borrow_Status']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fine']) . "</td>";
                                echo "</tr>";
                            }

                            echo "</table>";
                        } catch (PDOException $e) {
                            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page content -->

<?php
include "footer.php";
?>