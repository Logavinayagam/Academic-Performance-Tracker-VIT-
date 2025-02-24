<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Calculator</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js for Graph -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for Popup -->
</head>
<body>

<div class="container">
    <div class="grade-box">
        <h2>Grade Calculator</h2>
        <form id="gradeForm">
            <label>CAT 1 (Out of 50):</label>
            <input type="number" id="cat1" min="0" max="50" required>

            <label>CAT 2 (Out of 50):</label>
            <input type="number" id="cat2" min="0" max="50" required>

            <label>Assignment 1 / Quiz (Out of 10):</label>
            <input type="number" id="assign1" min="0" max="10" required>

            <label>Assignment 2 / Quiz (Out of 10):</label>
            <input type="number" id="assign2" min="0" max="10" required>

            <label>Quiz (Out of 10):</label>
            <input type="number" id="quiz" min="0" max="10" required>

            <label>FAT (Out of 100):</label>
            <input type="number" id="fat" min="0" max="100" required>

            <button type="button" class="btn calculate-btn" onclick="calculateGrade()">Calculate Grade</button>
        </form>
    </div>
</div>

<!-- Back to Dashboard Button -->
<a href="dashboard.php" class="btn back-btn">Back to Dashboard</a>

<!-- Result Popup -->
<div class="result-popup" id="resultPopup">
    <div class="result-box">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2>Your Grade</h2>
        <p id="finalGrade"></p>
        <p id="motivation"></p>
        <canvas id="gradeChart"></canvas>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script>
function calculateGrade() {
    // Get values
    let cat1 = parseFloat(document.getElementById('cat1').value) || 0;
    let cat2 = parseFloat(document.getElementById('cat2').value) || 0;
    let assign1 = parseFloat(document.getElementById('assign1').value) || 0;
    let assign2 = parseFloat(document.getElementById('assign2').value) || 0;
    let quiz = parseFloat(document.getElementById('quiz').value) || 0;
    let fat = parseFloat(document.getElementById('fat').value) || 0;

    // Calculate Weighted Marks (Total out of 100%)
    let total = (cat1 * 0.3) + (cat2 * 0.3) + (assign1 * 1) + (assign2 * 1) + (quiz * 1) + (fat * 0.4);

    let grade = "";
    let motivation = "";
    let colors = ["#FF0000", "#FF4500", "#FFD700", "#32CD32", "#008000"]; // Red -> Orange -> Yellow -> Green -> Dark Green

    if (total >= 90) {
        grade = "S";
        motivation = "Excellent! Keep up the great work! 🚀";
    } else if (total >= 80) {
        grade = "A";
        motivation = "Great job! You're on the right track! 🌟";
    } else if (total >= 70) {
        grade = "B";
        motivation = "Good effort! Keep pushing forward! 💪";
    } else if (total >= 60) {
        grade = "C";
        motivation = "Decent! A little more effort will get you there! 🔥";
    } else if (total >= 50) {
        grade = "D";
        motivation = "You passed, but aim for better next time! 🎯";
    } else {
        grade = "F";
        motivation = "Failure is the stepping stone to success! Don't give up! 🚀";
    }

    // Show Result Popup
    document.getElementById("finalGrade").innerHTML = `<strong>Grade:</strong> ${grade}`;
    document.getElementById("motivation").innerHTML = `<em>${motivation}</em>`;
    document.getElementById("resultPopup").style.display = "block";

    // Fixing Chart Issue by Destroying Old Instance Before Creating New One
    if (window.gradeChartInstance) {
        window.gradeChartInstance.destroy();
    }

    // Chart Data
    let ctx = document.getElementById("gradeChart").getContext("2d");
    window.gradeChartInstance = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["Your Score", "Remaining"],
            datasets: [{
                data: [total, 100 - total],
                backgroundColor: [colors[grade === "S" ? 4 : grade === "A" ? 3 : grade === "B" ? 2 : grade === "C" ? 1 : 0], "#ccc"]
            }]
        },
        options: {
            cutout: "70%",
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });
}

// Close Popup
function closePopup() {
    document.getElementById("resultPopup").style.display = "none";
}
</script>

</body>
</html>
