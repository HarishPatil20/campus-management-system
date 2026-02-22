<?php
session_start();
require_once 'config.php';

// Check if 'id' is provided in the URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM student WHERE st_id = ?");
    $stmt->bind_param("s", $student_id);

    // Execute and check if successful
    if ($stmt->execute()) {
        // Success: redirect back to student list
        header("Location: student_view.php?message=Student+deleted+successfully");
    } else {
        // Error: show an error message (you can improve this)
        echo "Error deleting student: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request: No student ID provided.";
}

$conn->close();
?>
