<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Academic Performance Tracker</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
    <div class="form-box">
        <h2>Student Login</h2>
        <form action="login_process.php" method="POST">
            <div class="input-group">
                <i class="fas fa-id-card"></i>
                <input type="text" name="student_id" placeholder="Student ID" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn login-btn">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
