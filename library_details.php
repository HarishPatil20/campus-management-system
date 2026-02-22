<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $lib_id = $_POST['lib_id'];
   $st_id = $_POST['student_id']; // match the form
    $book_id = $_POST['book_id'];
    $book_name = $_POST['book_name'];
    $issue_id = $_POST['issue_id']; // Optional since it's AUTO_INCREMENT, but included as you requested
    $issue_date = date('Y-m-d'); // current date in proper format


    // Check if same student already issued this book from this library
    $check_query = "SELECT * FROM library WHERE lib_id = '$lib_id' AND st_id = '$st_id' AND book_id = '$book_id'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        $_SESSION['book_error'] = "This student already issued this book from this library!";
    } else {
        // Now insert manually as you requested
        $sql = "INSERT INTO `library`(`lib_id`, `st_id`, `book_id`, `book_name`, `issue_id`, `issue_date`) 
                VALUES ('$lib_id', '$st_id', '$book_id', '$book_name', '$issue_id', '$issue_date')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_msg'] = "Book issued successfully!";
        } else {
            $_SESSION['book_error'] = "Insert failed: " . $conn->error;
        }
    }

    $conn->close();
    header("Location: library.php");
    exit();
}
?>
