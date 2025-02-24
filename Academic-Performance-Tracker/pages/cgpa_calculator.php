<?php 
include '../includes/header.php'; 
require_once "../config/database.php";

if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION["student_id"];

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch previous CGPA and completed credits from the `subjects` table
$query = "SELECT SUM(s.grade * s.credits) / SUM(s.credits) AS prev_cgpa, SUM(s.credits) AS completed_credits 
          FROM subjects s 
          WHERE s.student_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$prev_cgpa = $row["prev_cgpa"] ? number_format($row["prev_cgpa"], 2) : 0;
$completed_credits = $row["completed_credits"] ? $row["completed_credits"] : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CGPA Calculator</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container">
    <div class="cgpa-box">
        <h2>CGPA Calculator</h2>
        <form id="cgpaForm">
            <div class="input-group">
                <label>Previous CGPA:</label>
                <input type="number" id="prev_cgpa" step="0.01" value="<?php echo $prev_cgpa; ?>" required>
            </div>

            <div class="input-group">
                <label>Completed Credits:</label>
                <input type="number" id="completed_credits" value="<?php echo $completed_credits; ?>" required>
            </div>

            <div class="input-group">
                <label>Current GPA:</label>
                <input type="number" id="current_gpa" step="0.01" placeholder="Enter Current GPA" required>
            </div>

            <div class="input-group">
                <label>Current Semester Credits:</label>
                <input type="number" id="current_credits" placeholder="Enter Current Semester Credits" required>
            </div>

            <button type="button" class="btn calculate-btn" onclick="calculateCGPA()">Calculate CGPA</button>
        </form>
    </div>
</div>


<!-- Back to Dashboard Button -->
<a href="dashboard.php" class="btn back-btn">Back to Dashboard</a>

<!-- Result Popup -->
<div class="result-popup" id="resultPopup">
    <div class="result-box">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2>Your CGPA</h2>
        <p id="cgpaResult"></p>
        <canvas id="cgpaChart"></canvas>
        <button class="btn save-btn" onclick="showSavePopup()">Save CGPA</button>
    </div>
</div>

<!-- Save CGPA Popup -->
<div class="result-popup" id="savePopup">
    <div class="result-box">
        <span class="close-btn" onclick="closeSavePopup()">&times;</span>
        <h2>Save CGPA</h2>
        <label>Select Semester:</label>
        <select id="cgpa_semester">
            <?php for ($i = 1; $i <= 10; $i++) echo "<option value='$i'>Semester $i</option>"; ?>
        </select>
        <button class="btn confirm-save-btn" onclick="saveCGPA()">Confirm Save</button>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script>
let cgpaValue = 0;

function calculateCGPA() {
    let prev_cgpa = parseFloat(document.getElementById("prev_cgpa").value) || 0;
    let completed_credits = parseInt(document.getElementById("completed_credits").value) || 0;
    let current_gpa = parseFloat(document.getElementById("current_gpa").value) || 0;
    let current_credits = parseInt(document.getElementById("current_credits").value) || 0;

    let total_credits = completed_credits + current_credits;
    let total_gpa_points = (prev_cgpa * completed_credits) + (current_gpa * current_credits);
    cgpaValue = total_credits ? (total_gpa_points / total_credits).toFixed(2) : 0;

    document.getElementById("cgpaResult").innerHTML = `<strong>CGPA:</strong> ${cgpaValue}`;
    document.getElementById("resultPopup").style.display = "block";

    if (window.cgpaChartInstance) {
        window.cgpaChartInstance.destroy();
    }

    let ctx = document.getElementById("cgpaChart").getContext("2d");
    window.cgpaChartInstance = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["CGPA", "Remaining"],
            datasets: [{
                data: [cgpaValue * 10, 100 - (cgpaValue * 10)],
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

function showSavePopup() {
    document.getElementById("savePopup").style.display = "block";
}

function saveCGPA() {
    let semester = document.getElementById("cgpa_semester").value;
    $.ajax({
        type: "POST",
        url: "save_cgpa.php",
        data: { cgpa: cgpaValue, semester: semester },
        success: function(response) {
            alert(response);
            closeSavePopup();
        },
        error: function() {
            alert("Error saving CGPA. Try again!");
        }
    });
}

function closePopup() { document.getElementById("resultPopup").style.display = "none"; }
function closeSavePopup() { document.getElementById("savePopup").style.display = "none"; }
</script>

</body>
</html>
