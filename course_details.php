<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $credits = $_POST['credits'];
    $dept_id = $_POST['dept_id'];
    $faculty_id = $_POST['faculty_id'];
    

    $checkcourse_id = $conn->query("SELECT course_id FROM courses WHERE course_id = '$course_id'");
    
    if ($checkcourse_id->num_rows > 0) {
        $_SESSION['course_error'] = "course ID already registered!";

    } else {
        $sql = "INSERT INTO `courses`(`course_id`, `course_name`, `credits`, `dept_id`, `faculty_id`) 
        VALUES ('$course_id', '$course_name', '$credits', '$dept_id','$faculty_id')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_msg'] = "course data inserted successfully!";
        } else {
            $_SESSION['course_error'] = "Error: " . $conn->error;
        }
    }

    $conn->close();
    header("Location: courses.php");
    exit();
}
?>