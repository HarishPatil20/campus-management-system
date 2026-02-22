<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $department_id = $_POST['department_id'];
    $department_name = $_POST['department_name'];
    $department_hod = $_POST['department_hod'];
   
    

    $checkdepartment_id = $conn->query("SELECT department_id FROM department WHERE department_id = '$department_id'");
    
    if ($checkdepartment_id->num_rows > 0) {
        $_SESSION['department_error'] = "department ID already registered!";

    } else {
        $sql = "INSERT INTO `department`(`department_id`, `department_name`, `department_hod`) 
        VALUES ('$department_id', '$department_name', '$department_hod')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_msg'] = "department data inserted successfully!";
        } else {
            $_SESSION['department_error'] = "Error: " . $conn->error;
        }
    }

    $conn->close();
    header("Location: department.php");
    exit();
}
?>