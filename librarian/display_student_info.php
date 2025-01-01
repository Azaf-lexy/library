<?php
include "header.php";
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
                        <?php
                        // Fetch student data
                        include "connection.php"; // Ensure connection is included
                        try {
                            $stmt = $conn->query("SELECT id, username, email, role FROM student_registration");
                            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "<div class='alert alert-danger'>Error fetching data: " . htmlspecialchars($e->getMessage()) . "</div>";
                        }
                        ?>
                        <table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody id="studentTable">
                                <?php
                                if (!empty($results)) {
                                    foreach ($results as $key => $value) {
                                        echo '<tr>
                                                <td>' . htmlspecialchars($value['id']) . '</td>
                                                <td>' . htmlspecialchars($value['username']) . '</td>
                                                <td>' . htmlspecialchars($value['email']) . '</td>
                                                <td>' . htmlspecialchars($value['role']) . '</td>
                                              </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="4">No students found.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
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
                    <button type="button" id="submitButton" class="btn btn-primary">Insert</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('submitButton').addEventListener('click', function() {
    const formData = new FormData(document.getElementById('addStudentForm'));

    fetch('add_student_ajax.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const newRow = `<tr>
                <td>${data.student.id}</td>
                <td>${data.student.username}</td>
                <td>${data.student.email}</td>
                <td>${data.student.role}</td>
            </tr>`;
            document.getElementById('studentTable').insertAdjacentHTML('beforeend', newRow);
            $('#addStudentModal').modal('hide');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>

<?php
include "footer.php";
?>
