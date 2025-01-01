<?php
include "header.php";
include "connection.php"; // Includes the PDO connection
$book_dropdown = dropdown_books();
$student_dropdown = dropdown_student();

?>

<!-- page content area main -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Add Borrow Book Details</h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row" style="min-height:500px">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Borrow Books Info</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form name="form1" action="" method="post" class="col-lg-6" enctype="multipart/form-data">
                            <table class="table table-bordered">


                                <tr>
                                    <td>
                                        <label for="username">Student Name:</label>
                                        <select name="student_name" class="form-control" required>
                                            <option value="">Select a Student</option>
                                            <?php if (isset($student_dropdown)) {
                                                foreach ($student_dropdown as $sd) { ?>
                                                    <option value="<?= $sd['username'] ?>"><?= $sd['username'] ?></option>
                                          
                                          <?php

                                                };
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="book_name">Book Name:</label>
                                        <select name="book_name" class="form-control" required>
                                            <option value="">Select a Book</option>
                                            <?php if (isset($book_dropdown)) {
                                                foreach ($book_dropdown as $bd) { ?>
                                                    <option value="<?= $bd['book_name'] ?>"><?= $bd['book_name'] ?></option>
                                            <?php
                                                };
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="borrow_Date">Borrow Date:</label>
                                        <input type="date" class="form-control" name="borrow_Date" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="return_Date">Returned Date:</label>
                                        <input type="date" class="form-control" name="return_Date">
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="due_date">Due Date:</label>
                                        <input type="date" class="form-control" name="due_date"
                                            required>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="submit" name="submit1" class="btn btn-primary" value="Insert Book Details" style="background-color: #912633; color:white">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST["submit1"])) {
    try {
        // Prepare and bind
        $stmt = $conn->prepare("
            INSERT INTO borrow (student_name, book_name, borrow_Date, return_Date,due_date) 
            VALUES (:student_name, :book_name, :borrow_Date, :return_Date,:due_date)
        ");

        // Bind parameters
        $stmt->bindParam(':student_name', $_POST["student_name"]);
        $stmt->bindParam(':book_name', $_POST["book_name"]);
        $stmt->bindParam(':borrow_Date', $_POST["borrow_Date"]);
        $stmt->bindParam(':return_Date', $_POST["return_Date"]);
        $stmt->bindParam(':due_date', $_POST["due_date"]);

        // Execute the statement
        $stmt->execute();

        echo '<script type="text/javascript">alert("Book inserted successfully!");</script>';
    } catch (PDOException $e) {
        echo '<script type="text/javascript">alert("Error inserting book: ' . addslashes($e->getMessage()) . '");</script>';
    }
}
?>

<?php
include "footer.php";
?>