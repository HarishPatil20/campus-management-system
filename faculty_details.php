<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $faculty_id = $_POST['faculty_id'];
    $faculty_name = $_POST['faculty_name'];
    $department_id = $_POST['department_id'];
    $emai = $_POST['email'];
    

    $checkfaculty_id = $conn->query("SELECT faculty_id FROM faculty WHERE faculty_id = '$faculty_id'");
    
    if ($checkfaculty_id->num_rows > 0) {
        $_SESSION['faculty_error'] = "Faculty ID already registered!";

    } else {
        $sql = "INSERT INTO faculty (faculty_id, faculty_name, dept_id,email)
                VALUES ('$faculty_id', '$faculty_name', '$department_id','$emai')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_msg'] = "faculty data inserted successfully!";
        } else {
            $_SESSION['faculty_error'] = "Error: " . $conn->error;
        }
    }

    $conn->close();
    header("Location: faculty.php");
    exit();
}
?>