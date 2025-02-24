<?php 
include '../includes/header.php'; 
require_once "../config/database.php";

if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION["student_id"];

// Fetch CGPA & GPA history for performance chart
$query = "SELECT semester_no, gpa, cgpa FROM semesters WHERE student_id = ? ORDER BY semester_no";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$gpa_data = [];
$cgpa_data = [];
$semesters = [];

while ($row = $result->fetch_assoc()) {
    $semesters[] = "Sem " . $row["semester_no"];
    $gpa_data[] = $row["gpa"];
    $cgpa_data[] = $row["cgpa"];
}

// Fetch current CGPA & completed credits
$query = "SELECT SUM(s.grade * s.credits) / SUM(s.credits) AS current_cgpa, SUM(s.credits) AS completed_credits 
          FROM subjects s 
          WHERE s.student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$current_cgpa = $row["current_cgpa"] ? number_format($row["current_cgpa"], 2) : 0;
$completed_credits = $row["completed_credits"] ? $row["completed_credits"] : 0;

// Define Total Credits & Semesters in VIT
$total_semesters = 8;
$total_credits = 160;

// Calculate Remaining Semesters & Credits
$completed_semesters = ceil(($completed_credits / $total_credits) * $total_semesters);
$remaining_semesters = $total_semesters - $completed_semesters;
$remaining_credits = $total_credits - $completed_credits;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goal Setting</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container">
    <div class="goal-box">
        <h2>Set Your Academic Goal</h2>
        <form id="goalForm">
            <div class="input-group">
                <label>Current CGPA:</label>
                <input type="number" id="current_cgpa" step="0.01" value="<?php echo $current_cgpa; ?>" required>
            </div>

            <div class="input-group">
                <label>Completed Semesters:</label>
                <input type="number" id="completed_semesters" value="<?php echo $completed_semesters; ?>" required>
            </div>

            <div class="input-group">
                <label>Remaining Semesters:</label>
                <input type="number" id="remaining_semesters" value="<?php echo $remaining_semesters; ?>" required>
            </div>

            <div class="input-group">
                <label>Target CGPA:</label>
                <input type="number" id="target_cgpa" step="0.01" placeholder="Enter Target CGPA" required>
            </div>

            <button type="button" class="btn calculate-btn" onclick="calculateRequiredGPA()">Calculate Plan</button>
        </form>

        <!-- Performance Chart -->
        <h3>Performance Chart</h3>
        <canvas id="performanceChart"></canvas>
    </div>
</div>

<!-- Back to Dashboard Button -->
<a href="dashboard.php" class="btn back-btn">Back to Dashboard</a>

<!-- Result Popup -->
<div class="result-popup" id="resultPopup">
    <div class="result-box">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2>How to Achieve Your Goal</h2>
        <p id="goalResult"></p>
        <button class="btn save-btn" onclick="saveGoal()">Save Goal</button>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script>
const semesters = <?php echo json_encode($semesters); ?>;
const gpaData = <?php echo json_encode($gpa_data); ?>;
const cgpaData = <?php echo json_encode($cgpa_data); ?>;

let ctx = document.getElementById("performanceChart").getContext("2d");
let performanceChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: semesters,
        datasets: [
            {
                label: "GPA Progress",
                data: gpaData,
                borderColor: "#ff7e5f",
                backgroundColor: "rgba(255, 126, 95, 0.3)",
                fill: true
            },
            {
                label: "CGPA Progress",
                data: cgpaData,
                borderColor: "#43cea2",
                backgroundColor: "rgba(67, 206, 162, 0.3)",
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                max: 10
            }
        }
    }
});

function calculateRequiredGPA() {
    let current_cgpa = parseFloat(document.getElementById("current_cgpa").value);
    let completed_semesters = parseInt(document.getElementById("completed_semesters").value);
    let remaining_semesters = parseInt(document.getElementById("remaining_semesters").value);
    let target_cgpa = parseFloat(document.getElementById("target_cgpa").value);

    if (target_cgpa > 10) {
        target_cgpa = 10;
    }

    let required_gpa = ((target_cgpa * (completed_semesters + remaining_semesters)) - (current_cgpa * completed_semesters)) / remaining_semesters;
    
    if (required_gpa > 10) {
        required_gpa = 10;
        target_cgpa = ((current_cgpa * completed_semesters) + (required_gpa * remaining_semesters)) / (completed_semesters + remaining_semesters);
        target_cgpa = target_cgpa.toFixed(2);
    }

    required_gpa = required_gpa.toFixed(2);

    document.getElementById("goalResult").innerHTML = `<strong>To achieve a CGPA of ${target_cgpa}, you need an average GPA of <span style="color: #ff7e5f;">${required_gpa}</span> for the remaining semesters.</strong>`;
    document.getElementById("resultPopup").style.display = "block";
}

function saveGoal() {
    let target_cgpa = document.getElementById("target_cgpa").value;

    $.ajax({
        type: "POST",
        url: "save_goal.php",
        data: { target_cgpa: target_cgpa },
        success: function(response) {
            alert(response);
            closePopup();
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: ", error);
            alert("Error saving goal. Check console for details.");
        }
    });
}


function closePopup() { document.getElementById("resultPopup").style.display = "none"; }
</script>

</body>
</html>
