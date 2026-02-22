<?php
session_start();
require_once 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $grade_id = $_POST['grade_id'];
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $grade = $_POST['grade'];
    $semester = $_POST['semester'];

    // 1. Check if grade_id already exists
    $check_grade_id = $conn->query("SELECT grade_id FROM grades WHERE grade_id = '$grade_id'");

    if ($check_grade_id->num_rows > 0) {
        $_SESSION['grade_error'] = "Grade ID already registered!";
    } else {
        // 2. Check if this student already has a grade for this course
        $check_student_course = $conn->query("SELECT * FROM grades WHERE student_id = '$student_id' AND course_id = '$course_id'");

        if ($check_student_course->num_rows > 0) {
            $_SESSION['grade_error'] = "Student already has a grade for this course!";
        } else {
            // 3. Verify that the student's semester matches the entered semester
            $student_sem_query = $conn->query("SELECT semester FROM student WHERE st_id = '$student_id'");

            if ($student_sem_query->num_rows > 0) {
                $student_data = $student_sem_query->fetch_assoc();
                $correct_semester = (int)$student_data['semester']; // convert to integer

                if ($correct_semester !== (int)$semester) {
                    $_SESSION['grade_error'] = "Entered semester does not match student's actual semester!";
                } else {
                    // Semester matches, insert the data now
                    $sql = "INSERT INTO grades (grade_id, student_id, course_id, grade, semester) 
                            VALUES ('$grade_id', '$student_id', '$course_id', '$grade', '$semester')";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['success_msg'] = "Grade inserted successfully!";
                    } else {
                        $_SESSION['grade_error'] = "Database Error: " . $conn->error;
                    }
                }
            } else {
                $_SESSION['grade_error'] = "Student ID not found in database!";
            }
        }
    }

    $conn->close();
    header("Location: grade.php");
    exit();
}
?>
