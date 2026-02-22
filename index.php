<?php
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];

$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DBMS mini project</title>
<link rel="stylesheet" href="style.css">
<style>
/* Logo styling */
.logo-container {
    text-align: center;
    margin-bottom: 15px; /* space between logo and form */
}

.logo {
    width: 80px; /* adjust the size as needed */
    height: auto;
}

/* Optional: small tweaks for error messages */
.error-message {
    color: red;
    text-align: center;
    margin-bottom: 10px;
}
</style>
</head>
<body>
<div class="container">

    <!-- Login Form -->
    <div class="form-box <?= isActiveForm('login',$activeForm);?>" id="login-form">
        <div class="logo-container">
            <img src="image/logo.png" alt="Logo" class="logo">
        </div>
        <form action="login_register.php" method="post">
            <h2>Login</h2>
            <?= showError($errors['login']); ?>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
            <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
        </form>
    </div>

    <!-- Register Form -->
    <div class="form-box <?= isActiveForm('register',$activeForm);?>" id="register-form">
        <div class="logo-container">
            <img src="image/logo.png" alt="Logo" class="logo">
        </div>
        <form action="login_register.php" method="post">
            <h2>Register</h2>
            <?= showError($errors['register']); ?>
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value=""> -- Select Role --</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="register">Register</button>
            <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
        </form>
    </div>

</div>

<script src="script.js"></script>
<script>
    // Auto-hide alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.style.display = 'none', 500);
        });
    }, 4000); // hides after 4 seconds
</script>
</body>
</html>
