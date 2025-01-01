<?php
include "connection.php"; // Your PDO connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        header h1 {
            margin: 0;
        }

        nav {
            background-color: #444;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 15px;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: #555;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            text-align: center;
        }

        .buttons a {
            text-decoration: none;
            color: #fff;
            background-color: #5cb85c;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
        }

        .buttons a:hover {
            background-color: #4cae4c;
        }

        .announcements {
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .announcement-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        footer {
            text-align: center;
            background-color: #333;
            color: white;
            padding: 15px 0;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Library Management System</h1>
    </header>

    <div class="container">
        <h2>Welcome to the Library Management System</h2>
        <p>A simple and efficient way to manage your library's books, users, and announcements.</p>

        <div class="buttons">
            
            <a href="login.php">Login</a>
        </div>

        <div class="announcements">
            <h3>Latest Announcements</h3>
            <?php
            try {
                // Fetch latest announcements from the database using PDO
                $sql = "SELECT * FROM librarian_registration ORDER BY username DESC LIMIT 5";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($results) > 0) {
                    foreach ($results as $row) {
                        echo '<div class="announcement-item">';
                        echo '<strong>' . $row['username'] . '</strong>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="announcement-item">No announcements available at the moment.</div>';
                }
            } catch (PDOException $e) {
                echo '<div class="announcement-item">Error: ' . $e->getMessage() . '</div>';
            }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Library Management System</p>
    </footer>
</body>

</html>
