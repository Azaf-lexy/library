<?php

function fetchAll($table_name)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM $table_name");
    $stmt->execute();
    // Fetch all results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function loginCheck($table_name, $email, $password)
{
    global $conn;

    // Prepare a secure SQL query with placeholders
    $stmt = $conn->prepare("SELECT * FROM $table_name WHERE email = :email");

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':email', $email);

    // Execute the query
    $stmt->execute();

    // Fetch the user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // return $user['password'];
    // Verify the password
    if (($user['password'] == hash('sha256', $password))) {
        // Password matches
        return $user;
    } else {
        // Login failed
        return false;
    }
}
