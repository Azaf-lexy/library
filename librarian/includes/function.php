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
function getAttribute($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return NULL;
        }
    }
    function borrow_student($student_name)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM borrow WHERE student_name = :student_name" );
        $stmt->bindParam(':student_name', $student_name);
        $stmt->execute();

        // Fetch all results as an associative array
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    function dropdown_books()
    {
        global $conn;
        $stmt = $conn->prepare("SELECT book_name FROM add_books ");
        $stmt->execute();

        // Fetch all results as an associative array
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    function dropdown_student()
    {
        global $conn;
        $stmt = $conn->prepare("SELECT username FROM student_registration WHERE role = 'member' ");
        $stmt->execute();

        // Fetch all results as an associative array
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }