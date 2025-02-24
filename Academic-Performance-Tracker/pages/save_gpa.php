<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION["student_id"])) {
    echo "Error: User not logged in!";
    exit();
}

if (isset($_POST["gpa"]) && isset($_POST["semester"])) {
    $student_id = $_SESSION["student_id"];
    $gpa = floatval($_POST["gpa"]);
    $semester = intval($_POST["semester"]);

    // Insert or Update GPA
    $query = "INSERT INTO semesters (student_id, semester_no, gpa) 
              VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE gpa = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sidd", $student_id, $semester, $gpa, $gpa);
    $stmt->execute();

    // Fetch previous CGPA
    $query = "SELECT SUM(gpa) / COUNT(gpa) AS new_cgpa FROM semesters WHERE student_id = ? AND semester_no <= ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $student_id, $semester);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $new_cgpa = $row["new_cgpa"];

    // Update CGPA for this semester
    $query = "UPDATE semesters SET cgpa = ? WHERE student_id = ? AND semester_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("dsi", $new_cgpa, $student_id, $semester);
    $stmt->execute();

    echo "GPA saved and CGPA updated!";
}
?>
