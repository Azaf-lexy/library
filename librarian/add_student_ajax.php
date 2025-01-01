<?php
include "connection.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $role = $_POST['role'];

        $stmt = $conn->prepare("INSERT INTO student_registration (username, password, email, role) VALUES (:username, :password, :email, :role)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        $lastId = $conn->lastInsertId();
        echo json_encode([
            'success' => true,
            'student' => [
                'id' => $lastId,
                'username' => htmlspecialchars($username),
                'email' => htmlspecialchars($email),
                'role' => htmlspecialchars($role),
            ],
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
