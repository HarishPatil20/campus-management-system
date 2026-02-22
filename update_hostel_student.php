<?php
session_start();
require_once 'config.php';

$st_id = $_GET['st_id'] ?? '';

if ($st_id) {
    $stmt = $conn->prepare("SELECT * FROM hostel WHERE st_id=?");
    $stmt->bind_param("s", $st_id);
    $stmt->execute();
    $student = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hostel_name = $_POST['hostel_name'];
    $contact = $_POST['contact'];
    $roomno = $_POST['roomno'];
    $block = $_POST['block'];
    $type = $_POST['type'];

    $stmt = $conn->prepare("UPDATE hostel SET hostel_name=?, contact=?, roomno=?, block=?, type=? WHERE st_id=?");
    $stmt->bind_param("ssssss", $hostel_name, $contact, $roomno, $block, $type, $st_id);
    $stmt->execute();

    header("Location: hostel_st_select.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Hostel</title>
    <link rel="stylesheet" href="style.css"> <!-- same CSS as student form -->
</head>
<body>

<div class="container">
    <div class="form-box1" id="student"> <!-- same ID and class -->
        <form method="POST">
            <h2>Update Hostel</h2>

            <label>Hostel Name:</label>
            <input type="text" name="hostel_name" value="<?php echo htmlspecialchars($student['hostel_name']); ?>" required><br><br>

            <label>Contact:</label>
            <input type="text" name="contact" value="<?php echo htmlspecialchars($student['contact']); ?>" required><br><br>

            <label>Room No:</label>
            <input type="text" name="roomno" value="<?php echo htmlspecialchars($student['roomno']); ?>" required><br><br>

            <label>Block:</label>
            <input type="text" name="block" value="<?php echo htmlspecialchars($student['block']); ?>" required><br><br>

            <label>Type:</label>
            <select name="type" required>
                <option value="Boys" <?php if($student['type']=="Boys") echo "selected"; ?>>Boys</option>
                <option value="Girls" <?php if($student['type']=="Girls") echo "selected"; ?>>Girls</option>
            </select><br><br>

            <button type="submit">Update</button>
        </form>
    </div>
</div>

</body>
</html>
