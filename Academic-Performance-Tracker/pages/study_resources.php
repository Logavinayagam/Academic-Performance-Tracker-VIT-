<?php 
include '../includes/header.php'; 
require_once "../config/database.php";

if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION["student_id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Resources</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Back to Dashboard Button (Right Corner) -->
<div class="dashboard-link">
    <a href="dashboard.php" class="btn back-btn">Back to Dashboard</a>
</div>

<div class="container">
    <div class="resource-box">
        <h2>Study Resources</h2>

        <h3>📚 Online Learning Platforms</h3>
        <ul>
            <li><a href="https://www.coursera.org/" target="_blank">Coursera</a></li>
            <li><a href="https://www.udemy.com/" target="_blank">Udemy</a></li>
            <li><a href="https://www.edx.org/" target="_blank">edX</a></li>
            <li><a href="https://ocw.mit.edu/" target="_blank">MIT OpenCourseWare</a></li>
            <li><a href="https://www.khanacademy.org/" target="_blank">Khan Academy</a></li>
        </ul>

        <h3>📖 Find Books in VIT Library</h3>
        <a href="https://webopac.vit.ac.in/" target="_blank" class="btn library-btn">VIT Library</a>

        <h3>📌 Other Useful Links</h3>
        <ul>
            <li><a href="https://www.javatpoint.com/" target="_blank">JavaTpoint</a></li>
            <li><a href="https://www.geeksforgeeks.org/" target="_blank">GeeksforGeeks</a></li>
            <li><a href="https://www.w3schools.com/" target="_blank">W3Schools</a></li>
            <li><a href="https://developer.mozilla.org/en-US/" target="_blank">MDN Web Docs</a></li>
        </ul>
    </div>
</div>

<!-- Feedback Form -->
<div class="container">
    <div class="feedback-box">
        <h2>Feedback</h2>
        <textarea id="feedbackMessage" placeholder="Enter your feedback here..."></textarea>
        <button class="red-gradient-btn" onclick="submitFeedback()">Submit Feedback</button>

    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script>
function submitFeedback() {
    let message = $("#feedbackMessage").val().trim();
    if (message === "") {
        alert("Please enter your feedback before submitting.");
        return;
    }

    $.post("submit_feedback.php", { message: message }, function(response) {
        alert(response);
        $("#feedbackMessage").val(""); // Clear input after submission
    });
}
</script>

</body>
</html>
