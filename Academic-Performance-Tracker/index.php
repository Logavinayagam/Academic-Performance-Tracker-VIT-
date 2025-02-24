<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Performance Tracker (VIT)</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Link CSS file -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- FontAwesome Icons -->
</head>
<body>

<div class="container">
    <div class="intro-box">
        <h1>Welcome to Academic Performance Tracker</h1>
        <p>Track your **grades, CGPA, GPA, and attendance** with ease.  
        Set academic goals, get study suggestions, and analyze your performance visually.  
        Join us now and take control of your academic progress!</p>

        <div class="button-group">
            <a href="pages/login.php" class="btn login-btn">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
            <a href="pages/register.php" class="btn register-btn">
                <i class="fas fa-user-plus"></i> Register
            </a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
