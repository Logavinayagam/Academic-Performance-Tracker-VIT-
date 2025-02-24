<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Tracker</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js for Graph -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for Popup -->
</head>
<body>

<div class="container">
    <div class="attendance-box">
        <h2>Attendance Tracker</h2>
        <form id="attendanceForm">
            <label>Subject Name:</label>
            <input type="text" id="subject" placeholder="Enter Subject Name" required>
            
            <label>Attended Classes:</label>
            <input type="number" id="attended" min="0" required>
            
            <label>Total Classes:</label>
            <input type="number" id="total" min="1" required>

            <button type="button" class="btn calculate-btn" onclick="calculateAttendance()">Check Attendance</button>
        </form>
    </div>
</div>

<!-- Back to Dashboard Button -->
<a href="dashboard.php" class="btn back-btn">Back to Dashboard</a>

<!-- Result Popup -->
<div class="result-popup" id="resultPopup">
    <div class="result-box">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2>Attendance Result</h2>
        <p id="attendanceResult"></p>
        <p id="attendanceMessage"></p>
        <canvas id="attendanceChart"></canvas>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script>
function calculateAttendance() {
    let subject = document.getElementById("subject").value;
    let attended = parseFloat(document.getElementById("attended").value) || 0;
    let total = parseFloat(document.getElementById("total").value) || 1; // Avoid division by zero

    if (attended > total) {
        alert("Attended classes cannot be more than total classes!");
        return;
    }

    let percentage = ((attended / total) * 100).toFixed(2);
    let message = "";
    let color = percentage >= 75 ? "#32CD32" : percentage >= 70 ? "#FFD700" : "#FF4500"; // Green, Yellow, Red

    if (percentage >= 90) {
        message = "Excellent! Keep up the perfect attendance! 🎉";
    } else if (percentage >= 75) {
        message = "You're eligible for exams! Keep going! ✅";
    } else if (percentage >= 70) {
        message = "Warning! Attend more classes to be safe! ⚠️";
    } else {
        message = "You need to improve! Attend more classes! 🚨";
    }

    // Show Popup Result
    document.getElementById("attendanceResult").innerHTML = `<strong>Subject:</strong> ${subject} <br> <strong>Attendance:</strong> ${percentage}%`;
    document.getElementById("attendanceMessage").innerHTML = `<em>${message}</em>`;
    document.getElementById("resultPopup").style.display = "block";

    // Fixing Chart Issue by Destroying Old Instance Before Creating New One
    if (window.attendanceChartInstance) {
        window.attendanceChartInstance.destroy();
    }

    // Chart Data
    let ctx = document.getElementById("attendanceChart").getContext("2d");
    window.attendanceChartInstance = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["Attended", "Missed"],
            datasets: [{
                data: [attended, total - attended],
                backgroundColor: [color, "#ccc"]
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
