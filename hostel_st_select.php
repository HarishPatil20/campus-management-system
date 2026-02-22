<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$type = $_POST['type'] ?? '';
$roomno = $_POST['roomno'] ?? '';
$students = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $type && $roomno) {
    $stmt = $conn->prepare("SELECT * FROM hostel WHERE type=? AND roomno=?");
    $stmt->bind_param("ss", $type, $roomno);
    $stmt->execute();
    $students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hostel Student List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<header>
    <nav class="navigation">
      <ul>
        <li><a href="student.php">Student</a></li>
        <li><a href="faculty.php">Faculty</a></li>
        <li><a href="courses.php">Courses</a></li>
        <li><a href="grade.php">Grades</a></li>
        <li><a href="department.php">Department</a></li>
        <li><a href="library.php">Library</a></li>
        <li><a href="hostel.php">Hostel</a></li>
        <li><button onclick="window.location.href='logout.php'" class="logout-btn">Logout</button></li>
      </ul>
    </nav>
</header>
<div class="container">
    <h2>View Students in Hostel</h2>

    <!-- Filter form -->
     
    <div class="container">
    <div class="form-box1">
    <form method="POST">
        <label>Type:</label>
        <select name="type" required>
            <option value="">--Select Type--</option>
            <option value="Boys" <?php echo ($type=='Boys')?'selected':''; ?>>Boys</option>
            <option value="Girls" <?php echo ($type=='Girls')?'selected':''; ?>>Girls</option>
        </select><br>

        <label>Room Number:</label>
        <input type="text" name="roomno" value="<?php echo htmlspecialchars($roomno); ?>" required><br>

        <button type="submit">View Students</button>
    </form>
</div>
</div>

    <?php if ($students): ?>
        <h3>Room <?php echo htmlspecialchars($roomno); ?> (<?php echo htmlspecialchars($type); ?>)</h3>
        <p><strong>Total Students in Room:</strong> <?php echo count($students); ?></p>

        <table border="1" cellpadding="10" cellspacing="0" style="width:100%; background:#fff;">
            <thead style="background-color:#7494ec; color:white;">
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Block</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo $student['st_id']; ?></td>
                        <td><?php 
                            $res = $conn->query("SELECT st_name FROM student WHERE st_id='".$student['st_id']."'");
                            $row = $res->fetch_assoc();
                            echo htmlspecialchars($row['st_name'] ?? '');
                        ?></td>
                        <td><?php echo $student['contact']; ?></td>
                        <td><?php echo $student['block']; ?></td>
                        <td><?php echo $student['type']; ?></td>
                        <td>
                           <!-- Update button -->
<a href="update_hostel_student.php?st_id=<?php echo $student['st_id']; ?>" 
   style="padding: 4px 8px; font-size: 12px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px; margin-right: 5px;">
   Update
</a>

<!-- Delete button -->
<a href="delete_hostel_student.php?st_id=<?php echo $student['st_id']; ?>" 
   onclick="return confirm('Are you sure you want to delete this student?')" 
   style="padding: 4px 8px; font-size: 12px; background-color: #f44336; color: white; text-decoration: none; border-radius: 4px;">
   Delete
</a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>No students found in this room.</p>
    <?php endif; ?>

</div>
</body>
</html>
