<?php
// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Performance Tracker (VIT)</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link CSS -->
</head>
<body>

<header class="header">
    <div class="logo">
        Academic <span>Performance</span> Tracker
    </div>
</header>
