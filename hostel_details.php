<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $hostel_id = $_POST['hostel_id'];
    $st_id = $_POST['st_id'];
    $hostel_name = $_POST['hostel_name'];
    $contact = $_POST['contact'];
    $roomno = $_POST['roomno'];
    $block = $_POST['block'];
    $type = $_POST['type'];

    // Check if hostel_id already exists
    $checkhostel_id = $conn->query("SELECT hostel_id FROM hostel WHERE hostel_id = '$hostel_id'");

    // Check if student already assigned
    $checkst_id = $conn->query("SELECT st_id FROM hostel WHERE st_id = '$st_id'");

    if ($checkhostel_id->num_rows > 0) {
        $_SESSION['hostel_error'] = "This Hostel ID is already registered!";
    } elseif ($checkst_id->num_rows > 0) {
        $_SESSION['hostel_error'] = "This student is already assigned to a hostel!";
    } else {
        // ✅ Room count check: max 3 students per room
        $checkRoomCount = $conn->query("SELECT COUNT(*) as total FROM hostel WHERE roomno = '$roomno' AND type = '$type' AND hostel_name='$hostel_name'");
        $roomData = $checkRoomCount->fetch_assoc();

        if ($roomData['total'] >= 3) {
            $_SESSION['hostel_error'] = "Room is full or has already 3 members!";
        } else {
            $sql = "INSERT INTO hostel (hostel_name, st_id, contact, roomno, block, type) 
                    VALUES ('$hostel_name', '$st_id', '$contact', '$roomno', '$block', '$type')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['success_msg'] = "Hostel assignment successful!";
            } else {
                $_SESSION['hostel_error'] = "Error: " . $conn->error;
            }
        }
    }

    $conn->close();
    header("Location: hostel.php"); 
    exit();
}
?>
