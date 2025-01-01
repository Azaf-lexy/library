<?php
include "header.php";
include "connection.php"; // Includes the PDO connection
?>

<!-- page content area main -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Add Book Details</h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row" style="min-height:500px">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Books Info</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form name="form1" action="" method="post" class="col-lg-6" enctype="multipart/form-data">
                            <table class="table table-bordered">
                                <tr>
                                    <td><input type="text" class="form-control" placeholder="Books Name" name="booksname" required></td>
                                </tr>

                                <tr>
                                    <td>Books Image
                                        <input type="file" name="f1" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td><input type="text" class="form-control" placeholder="Books Author Name" name="bauthorname" required></td>
                                </tr>


                                <tr>
                                    <td><input type="date" class="form-control" placeholder="Books Purchase Date" name="bpurchasedt" required></td>
                                </tr>



                                <tr>
                                    <td><input type="number" class="form-control" placeholder="Books Quantity" name="bqty" required></td>
                                </tr>



                                <tr>
                                    <td>
                                        <input type="submit" name="submit1" class="btn btn-primary" value="Insert Book Details">
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
if (isset($_POST["submit1"]) && isset($_FILES["f1"])) {
    $tm = md5(time());
    $fnm = $_FILES["f1"]["name"];
    $dst = "./books_image/" . $tm . $fnm;

    if (!file_exists('./books_image/')) {
        mkdir('./books_image/', 0777, true);
    }

    if (move_uploaded_file($_FILES["f1"]["tmp_name"], $dst)) {
        try {
            // Prepare and bind
            $stmt = $conn->prepare("
                INSERT INTO add_books 
                (book_name, purchase_date, image_path,author_name,quantity) 
                VALUES (:book_name, :purchase_date, :image_path, :author_name, :quantity)
            ");

            $stmt->bindParam(':book_name', $_POST["booksname"]);
            $stmt->bindParam(':purchase_date', $_POST["bpurchasedt"]);
            $stmt->bindParam(':image_path', $dst);
            $stmt->bindParam(':author_name', $_POST["bauthorname"]);
            $stmt->bindParam(':quantity', $_POST["bqty"]);



            $stmt->execute();

            echo '<script type="text/javascript">alert("Book inserted successfully!");</script>';
        } catch (PDOException $e) {
            echo '<script type="text/javascript">alert("Error inserting book: ' . $e->getMessage() . '");</script>';
        }
    } else {
        echo '<script type="text/javascript">alert("Failed to upload file.");</script>';
    }
}
?>

<?php
include "footer.php";
?>