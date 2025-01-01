<?php
include "connection.php";
include "header.php";
?>

<!-- page content area main -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Display Books</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <form method="post">
                        <div class="input-group">
                            <input type="text" name="t1" class="form-control" placeholder="Search for Books...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit" name="submit1">Search</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row" style="min-height:500px">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Books List</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?php
                        try {
                            if (isset($_POST['submit1']) && !empty($_POST['t1'])) {
                                // Fetch books matching the search term
                                $searchTerm = "%" . trim($_POST['t1']) . "%";
                                $stmt = $conn->prepare("SELECT * FROM add_books WHERE book_name LIKE :searchTerm");
                                $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
                                $stmt->execute();
                            } else {
                                // Fetch all books if no search term is provided
                                $stmt = $conn->query("SELECT * FROM add_books");
                            }

                            echo "<table class='table table-bordered'>";
                            echo "<tr>";
                            echo "<th>ID </th>";
                            echo "<th>Books Name</th>";
                            echo "<th>Books Image</th>";
                            echo "<th>Author Name</th>";
                            echo "<th>Books Quantity</th>";
                            echo "<th>Purchase Date</th>";

                            echo "</tr>";

                            // Display the books
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['book_name']) . "</td>";
                                echo "<td><img src='" . htmlspecialchars($row['image_path']) . "' height='100' width='100'></td>";
                                echo "<td>" . htmlspecialchars($row['author_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['purchase_date']) . "</td>";
                                // echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                                echo "</tr>";
                            }

                            echo "</table>";
                        } catch (PDOException $e) {
                            echo '<div class="alert alert-danger">Error fetching books: ' . $e->getMessage() . '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<?php
include "footer.php";
?>