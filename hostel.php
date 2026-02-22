<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$students = $conn->query("SELECT st_id, st_name FROM student");
$next_hostel_id = '';
$result = $conn->query("SHOW TABLE STATUS LIKE 'hostel'");
if ($row = $result->fetch_assoc()) {
    $next_hostel_id = $row['Auto_increment'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hostel Form</title>
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
        <li><a href="#">Hostel</a></li>
        <li><button onclick="window.location.href='logout.php'" class="logout-btn">Logout</button></li>
      </ul>
    </nav>
</header>

<div class="container">
    <div class="form-box1">
        <form action="hostel_details.php" method="post">
          <h2>Hostel Assignment</h2>

          <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert success">
            <?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
            </div>
          <?php endif; ?>

          <?php if (isset($_SESSION['hostel_error'])): ?>
            <div class="alert error">
            <?php echo $_SESSION['hostel_error']; unset($_SESSION['hostel_error']); ?>
            </div>
          <?php endif; ?>

          <label>Hostel ID:</label>
          <input type="text" name="hostel_id" value="<?php echo $next_hostel_id; ?>" readonly><br>

          <label>Hostel Name:</label><input type="text" name="hostel_name" required><br>

          <label>Student:</label>
          <select name="st_id" required>
            <option value="">Select Student</option>
            <?php while ($student = $students->fetch_assoc()): ?>
              <option value="<?php echo $student['st_id']; ?>">
                <?php echo htmlspecialchars($student['st_name'] . " (" . $student['st_id'] . ")"); ?>
              </option>
            <?php endwhile; ?>
          </select><br>

          <label>Contact:</label><input type="text" name="contact" required><br>
          <label>Room No:</label><input type="text" name="roomno" required><br>
          <label>Block:</label>
          <select name="block" required>
            <option value="">--Blocks--</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select><br>

          <label>Type:</label>
          <select name="type" required>
            <option value="">--Select Hostel Type--</option>
            <option value="Boys">Boys</option>
            <option value="Girls">Girls</option>
          </select><br>

          <button type="submit">Submit</button>
          <button type="button" onclick="window.location.href='hostel_st_select.php'" class="view-btn">View Students</button>
        </form>
    </div>
</div>
</body>
</html>
