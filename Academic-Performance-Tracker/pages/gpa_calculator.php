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
    <title>GPA Calculator</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Back to Dashboard Button (Right Corner) -->
<div class="dashboard-link">
    <a href="dashboard.php" class="btn back-btn">Back to Dashboard</a>
</div>

<div class="container">
    <div class="gpa-box">
        <h2>GPA Calculator</h2>
        <form id="gpaForm">
            <div id="courseInputs">
                <div class="input-group">
                    <input type="text" class="course-name" placeholder="Enter Course Name" required>
                    <select class="grade" required>
                        <option value="" disabled selected>Enter Grade</option>
                        <option value="10">S (10)</option>
                        <option value="9">A (9)</option>
                        <option value="8">B (8)</option>
                        <option value="7">C (7)</option>
                        <option value="6">D (6)</option>
                        <option value="5">E (5)</option>
                        <option value="0">F (0)</option>
                    </select>
                    <input type="number" class="credit" placeholder="Enter Credits" min="1" required>
                    <button type="button" class="remove-btn" onclick="removeCourse(this)">✖</button>
                </div>
            </div>
            <button type="button" class="red-gradient-btn" onclick="addCourse()">+ Add Course</button>

            <button type="button" class="btn calculate-btn" onclick="calculateGPA()">Calculate GPA</button>
        </form>
    </div>
</div>

<!-- Result Popup -->
<div class="result-popup" id="resultPopup">
    <div class="result-box">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2>Your GPA</h2>
        <p id="gpaResult"></p>
        <canvas id="gpaChart"></canvas>
        <button class="btn save-btn" onclick="showSavePopup()">Save GPA</button>
    </div>
</div>

<!-- Save GPA Popup -->
<div class="result-popup" id="savePopup">
    <div class="result-box">
        <span class="close-btn" onclick="closeSavePopup()">&times;</span>
        <h2>Save GPA</h2>
        <label>Select Semester:</label>
        <select id="semester">
            <?php for ($i = 1; $i <= 10; $i++) echo "<option value='$i'>Semester $i</option>"; ?>
        </select>
        <button class="btn confirm-save-btn" onclick="saveGPA()">Confirm Save</button>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script>
let gpaValue = 0;

// Add a new course input row
function addCourse() {
    $("#courseInputs").append(`
        <div class="input-group">
            <input type="text" class="course-name" placeholder="Enter Course Name" required>
            <select class="grade" required>
                <option value="" disabled selected>Enter Grade</option>
                <option value="10">S (10)</option>
                <option value="9">A (9)</option>
                <option value="8">B (8)</option>
                <option value="7">C (7)</option>
                <option value="6">D (6)</option>
                <option value="5">E (5)</option>
                <option value="0">F (0)</option>
            </select>
            <input type="number" class="credit" placeholder="Enter Credits" min="1" required>
            <button type="button" class="remove-btn" onclick="removeCourse(this)">✖</button>
        </div>
    `);
}

// Remove a course row
function removeCourse(btn) {
    $(btn).closest(".input-group").remove();
}

// Calculate GPA
function calculateGPA() {
    let totalCredits = 0, totalPoints = 0;

    $(".input-group").each(function() {
        let grade = parseFloat($(this).find(".grade").val());
        let credits = parseFloat($(this).find(".credit").val()) || 0;
        totalPoints += grade * credits;
        totalCredits += credits;
    });

    gpaValue = totalCredits ? (totalPoints / totalCredits).toFixed(2) : 0;
    
    // Display result popup
    $("#gpaResult").html(`<strong>GPA:</strong> ${gpaValue}`);
    $("#resultPopup").show();

    if (window.gpaChartInstance) {
        window.gpaChartInstance.destroy();
    }

    let ctx = document.getElementById("gpaChart").getContext("2d");
    window.gpaChartInstance = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["GPA", "Remaining"],
            datasets: [{
                data: [gpaValue * 10, 100 - (gpaValue * 10)],
                backgroundColor: ["#43cea2", "#ccc"]
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

// Show Save GPA Popup
function showSavePopup() {
    $("#savePopup").show();
}

// Save GPA to Database & Update CGPA
function saveGPA() {
    let semester = $("#semester").val();
    $.post("save_gpa.php", { gpa: gpaValue, semester: semester }, function(response) {
        alert(response);
        closeSavePopup();
    });
}

// Close Popups
function closePopup() { $("#resultPopup").hide(); }
function closeSavePopup() { $("#savePopup").hide(); }
</script>

</body>
</html>
