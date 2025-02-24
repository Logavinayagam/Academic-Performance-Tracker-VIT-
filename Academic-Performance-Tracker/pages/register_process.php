<?php
session_start();
require_once "../config/database.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $student_id = trim($_POST["student_id"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Validate input
    if (empty($name) || empty($student_id) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION["error"] = "All fields are required!";
        header("Location: register.php");
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION["error"] = "Passwords do not match!";
        header("Location: register.php");
        exit();
    }

    // Hash password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if student ID or email already exists
    $check_query = "SELECT * FROM users WHERE student_id = ? OR email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ss", $student_id, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["error"] = "Student ID or Email already exists!";
        header("Location: register.php");
        exit();
    }

    // Insert user into the database
    $insert_query = "INSERT INTO users (student_id, name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssss", $student_id, $name, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION["success"] = "Registration successful! Please login.";
        header("Location: login.php");
    } else {
        $_SESSION["error"] = "Registration failed! Try again.";
        header("Location: register.php");
    }
}
?>
