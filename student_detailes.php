<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $sem = $_POST['sem'];
    $department_id = $_POST['department_id'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];

    // Check if USN already exists
    $checkstudent_id = $conn->query("SELECT st_id FROM student WHERE st_id = '$student_id'");

    // Check if email already exists
    $checkEmail = $conn->query("SELECT email FROM student WHERE email = '$email'");

    if ($checkstudent_id->num_rows > 0) {
        $_SESSION['stregister_error'] = "USN already registered!";
    } elseif ($checkEmail->num_rows > 0) {
        $_SESSION['stregister_error'] = "Email already registered!";
    } else {
        // Insert student data
        $sql = "INSERT INTO student (st_id, st_name, semester, dept_id, dob, email)
                VALUES ('$student_id', '$student_name', '$sem', '$department_id', '$dob', '$email')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_msg'] = "Student data inserted successfully!";
        } else {
            $_SESSION['stregister_error'] = "Error: " . $conn->error;
        }
    }

    $conn->close();
    header("Location: student.php");
    exit();
}
?>
