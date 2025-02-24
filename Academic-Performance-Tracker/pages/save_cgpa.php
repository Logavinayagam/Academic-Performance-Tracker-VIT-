<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION["student_id"])) {
    echo "Error: User not logged in!";
    exit();
}

if (isset($_POST["cgpa"]) && isset($_POST["semester"])) {
    $student_id = $_SESSION["student_id"];
    $cgpa = floatval($_POST["cgpa"]);
    $semester = intval($_POST["semester"]);

    $query = "INSERT INTO semesters (student_id, semester_no, cgpa) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE cgpa = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sidd", $student_id, $semester, $cgpa, $cgpa);
    
    if ($stmt->execute()) {
        echo "CGPA saved successfully!";
    } else {
        echo "Error saving CGPA!";
    }
} else {
    echo "Error: Invalid request!";
}
?>
