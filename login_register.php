<?php
session_start();
require_once 'config.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $checkEmail = $conn->query("SELECT email FROM register WHERE email = '$email'");
    if ($checkEmail && $checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered!';
        $_SESSION['active_form'] = 'register';
    } else {
        $insert = $conn->query("INSERT INTO register (name, email, password, role) VALUES('$name', '$email', '$password', '$role')");
        if ($insert) {
            $_SESSION['active_form'] = 'login'; // Show login form after register
        } else {
            $_SESSION['register_error'] = 'Registration failed. Try again!';
            $_SESSION['active_form'] = 'register';
        }
    }

    header("Location: index.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM register WHERE email = '$email'");
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            if ($user['role'] === 'admin') {
                header("Location: student.php");
            } else {
                header("Location: student.php");  // Corrected typo: "usre_page.php" -> "user_page.php"
            }
            exit();
        }
    }

    $_SESSION['login_error'] = 'Incorrect Email or Password!';
    $_SESSION['active_form'] = 'login';
    header("Location: index.php");
    exit();
}
?>
