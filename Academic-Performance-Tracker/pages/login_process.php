<?php
session_start();
require_once "../config/database.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST["student_id"]);
    $password = trim($_POST["password"]);

    // Validate input
    if (empty($student_id) || empty($password)) {
        $_SESSION["error"] = "All fields are required!";
        header("Location: login.php");
        exit();
    }

    // Check if student exists
    $query = "SELECT * FROM users WHERE student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password"])) {
            $_SESSION["student_id"] = $user["student_id"];
            $_SESSION["name"] = $user["name"];
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION["error"] = "Invalid credentials!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION["error"] = "Student ID not found!";
        header("Location: login.php");
        exit();
    }
}
?>
