<?php
include "header.php";
include "connection.php"; // Include your connection file
?>
<!-- page content area main -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>All Student Information</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row" style="min-height:500px">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Student List</h2>
                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addStudentModal">Add Student</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="studentTable">
                            <!-- Dynamic student table will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding Student -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="addStudentForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="member">Member</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Insert</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Function to load student table
        function loadStudentTable() {
            $.ajax({
                url: "fetch_students.php", // PHP script to fetch student data
                type: "GET",
                success: function (response) {
                    $("#studentTable").html(response);
                },
                error: function () {
                    alert("Failed to fetch student data.");
                }
            });
        }

        // Initial table load
        loadStudentTable();

        // Handle form submission
        $("#addStudentForm").on("submit", function (e) {
            e.preventDefault();

            $.ajax({
                url: "insert_student.php", // PHP script to handle student insert
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        alert("Student added successfully!");
                        loadStudentTable(); // Reload student table
                        $("#addStudentModal").modal("hide");
                        $("#addStudentForm")[0].reset();
                    } else {
                        alert("Failed to add student: " + res.message);
                    }
                },
                error: function () {
                    alert("An error occurred.");
                }
            });
        });
    });
</script>
<?php
include "footer.php";
?>
