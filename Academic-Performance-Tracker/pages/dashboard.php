<?php 
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}
include '../includes/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Academic Performance Tracker</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
    <!-- Dashboard Title -->
    <h2 class="dashboard-title">Dashboard</h2>

    <!-- Dashboard Options -->
    <div class="dashboard-options">
        <a href="grade.php" class="option">
            <img src="../assets/img/grades.png" alt="Grades">
            <span>Grade Calculator</span>
        </a>
        <a href="cgpa_calculator.php" class="option">
            <img src="../assets/img/cgpa.png" alt="CGPA">
            <span>CGPA Calculator</span>
        </a>
        <a href="gpa_calculator.php" class="option">
            <img src="../assets/img/gpa.png" alt="GPA">
            <span>GPA Calculator</span>
        </a>
        <a href="attendance.php" class="option">
            <img src="../assets/img/attendance.png" alt="Attendance">
            <span>Attendance Tracker</span>
        </a>
        <a href="goal_setting.php" class="option">
            <img src="../assets/img/goals.png" alt="Goals">
            <span>Set Academic Goals</span>
        </a>
        <a href="study_resources.php" class="option">
            <img src="../assets/img/resources.png" alt="Resources">
            <span>Study Resources</span>
        </a>
    </div>
</div>

<!-- Profile & Logout at Bottom -->
<div class="bottom-icons">
    <a href="profile.php" class="icon-link">
        <img src="../assets/img/profile.png" alt="Profile">
    </a>
    <a href="logout.php" class="icon-link">
        <img src="../assets/img/logout.png" alt="Logout">
    </a>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
