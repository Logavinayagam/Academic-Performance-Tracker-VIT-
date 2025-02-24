<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

require_once "../config/database.php"; // Database Connection

// Fetch student details
$student_id = $_SESSION['student_id'];
$query = "SELECT name, email FROM users WHERE student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch CGPA
$cgpa_query = "SELECT AVG(cgpa) AS overall_cgpa FROM semesters WHERE student_id = ?";
$stmt = $conn->prepare($cgpa_query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$cgpa_result = $stmt->get_result();
$cgpa_row = $cgpa_result->fetch_assoc();
$cgpa = $cgpa_row['overall_cgpa'] ? number_format($cgpa_row['overall_cgpa'], 2) : "N/A";

include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Academic Performance Tracker</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
    <div class="profile-box">
        <h2>Student Profile</h2>
        <img src="../assets/img/profile.png" alt="Profile Picture" class="profile-img">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student_id); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Current CGPA:</strong> <?php echo $cgpa; ?></p>
        
        <a href="dashboard.php" class="btn back-btn">Back to Dashboard</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
