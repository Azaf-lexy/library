<?php 
session_start();
include_once "../librarian/connection.php"; // Ensure $conn is properly defined here
include_once "../librarian/includes/function.php"; // Ensure $conn is properly defined here
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Login Form | LMS</title>
    <link href="../librarian/css/bootstrap.min.css" rel="stylesheet">
    <link href="../librarian/css/animate.min.css" rel="stylesheet">
    <link href="../librarian/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">

    <div class="col-lg-12 text-center">
        <h1 style="font-family:Lucida Console">Library Management System</h1>
    </div>

    <div class="login_wrapper">
        <section class="login_content">
            <form name="form1" action="" method="post">
                <h1>User Login Form</h1>
                <div>
                    <input type="email" name="email" class="form-control" placeholder="Email" required />
                </div>
                <div>
                    <input type="password" name="password" class="form-control" placeholder="Password" required />
                </div>
                <div>
                    <input class="btn btn-default submit" type="submit" name="submit1" value="Login">
                    <a class="reset_pass" href="#">Lost your password?</a>
                </div>
                <div class="clearfix"></div>
              
                <div class="separator">
           
                    <p class="change_link">New to site?
                        <a href="registration.php"> Create Account </a>
                    </p>
                    <div class="clearfix"></div>
                    <br />
                </div>
            </form>
        </section>
    </div>

    <?php
if (isset($_POST['submit1'])) {
    try {
        // Sanitize inputs
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        // Validate inputs
        if (empty($email) || empty($password)) {
            throw new Exception("Email and password are required.");
        }

        // Call loginCheck function
        $user = loginCheck('student_registration', $email, $password);

        if ($user) {
            // Start the session and set session variables
            session_start();
            $_SESSION['student_username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirect to dashboard
            header('Location: ../librarian/display_books.php');
            exit(); // Prevent further execution
        } else {
            echo '<div class="alert alert-danger col-lg-6 col-lg-push-3">Login Failed. Invalid email or password.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger col-lg-6 col-lg-push-3">Database Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger col-lg-6 col-lg-push-3">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}
?>
</body>

</html>
