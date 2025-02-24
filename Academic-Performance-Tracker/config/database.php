<?php
$host = "localhost";
$dbname = "academic_tracker"; // Database name
$username = "root"; // Default XAMPP user
$password = ""; // Default XAMPP password (empty)
$port = 4306; // XAMPP MySQL port

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Uncomment to check successful connection
// echo "Database Connected Successfully!";
?>
