<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION["student_id"])) {
    echo "Error: User not logged in!";
    exit();
}

if (isset($_POST["target_cgpa"])) {
    $student_id = $_SESSION["student_id"];
    $target_cgpa = floatval($_POST["target_cgpa"]);

    // Ensure CGPA is within limits
    if ($target_cgpa > 10) {
        echo "Error: Target CGPA cannot exceed 10!";
        exit();
    }

    // Check if the goal already exists
    $query = "SELECT * FROM goals WHERE student_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "SQL Error: " . $conn->error;
        exit();
    }

    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing goal
        $update_query = "UPDATE goals SET target_gpa = ? WHERE student_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ds", $target_cgpa, $student_id);
        if ($stmt->execute()) {
            echo "Goal updated successfully!";
        } else {
            echo "Error updating goal: " . $stmt->error;
        }
    } else {
        // Insert new goal
        $insert_query = "INSERT INTO goals (student_id, target_gpa) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sd", $student_id, $target_cgpa);
        if ($stmt->execute()) {
            echo "Goal saved successfully!";
        } else {
            echo "Error saving goal: " . $stmt->error;
        }
    }
} else {
    echo "Error: Invalid request!";
}
?>
