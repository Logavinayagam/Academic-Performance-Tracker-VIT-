<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION["student_id"])) {
    echo "Error: User not logged in!";
    exit();
}

if (isset($_POST["message"])) {
    $student_id = $_SESSION["student_id"];
    $message = trim($_POST["message"]);

    if ($message === "") {
        echo "Error: Feedback cannot be empty!";
        exit();
    }

    $query = "INSERT INTO feedback (student_id, message) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $student_id, $message);

    if ($stmt->execute()) {
        echo "Feedback submitted successfully!";
    } else {
        echo "Error submitting feedback: " . $stmt->error;
    }
} else {
    echo "Error: Invalid request!";
}
?>
