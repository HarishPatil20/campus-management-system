<?php
session_start();
require_once 'config.php'; // Include your database connection file

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
// Fetch the next auto-increment value
$next_grade_id = '';
$result = $conn->query("SHOW TABLE STATUS LIKE 'grades'");
if ($row = $result->fetch_assoc()) {
    $next_grade_id = $row['Auto_increment'];
}

$students = $conn->query("SELECT st_id, st_name FROM student");
$courses = $conn->query("SELECT * FROM courses");



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  
    <header>
 
        <nav class="navigation">
          <ul>
            <li><a href="student.php">Student</a></li>
            <li><a href="faculty.php">Faculty</a></li>
            <li><a href="courses.php">Courses</a></li>
            <li><a href="#">Grades</a></li>
            <li><a href="department.php">Department</a></li>
            <li><a href="library.php">Library</a></li>
            <li><a href="hostel.php">Hostel</a></li>
            <li><button onclick="window.location.href='logout.php'" class="logout-btn">Logout</button></li>
          </ul>
        </nav>
      </header>
    <div class="container">
        <div class="form-box1" id="student">
            <form action="grades_details.php" method="post">
                <h1>Grades</h1>

                <?php if (isset($_SESSION['success_msg'])): ?>
                  <div class="alert success">
                <?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
                  </div>
                <?php endif; ?>

              <?php if (isset($_SESSION['grade_error'])): ?>
            <div class="alert error">
            <?php echo $_SESSION['grade_error']; unset($_SESSION['grade_error']); ?>
            </div>
            <?php endif; ?>

                <label>Grade ID:</label>
                <input type="text" name="grade_id" value="<?php echo $next_grade_id; ?>" readonly><br>

                <label>Student ID:</label>
                <select name="student_id" class="student-dropdown" required>
                    <option value="">Select Student</option>
                      <?php while ($student = $students->fetch_assoc()): ?>
                    <option value="<?php echo $student['st_id']; ?>">
                      <?php echo htmlspecialchars($student['st_name'] . " (" . $student['st_id'] . ")"); ?>
                    </option>
                      <?php endwhile; ?>
                  </select><br>

                <label>Course ID:</label>
                <select name="course_id" class="student-dropdown" required>
                  <option value="">Select Course</option>
                    <?php while ($course = $courses->fetch_assoc()): ?>
                  <option value="<?php echo htmlspecialchars($course['course_id']); ?>">
                    <?php echo htmlspecialchars($course['course_name'] . " (" . $course['course_id'] . ")"); ?>
                  </option>
                    <?php endwhile; ?>
                </select><br>

                <label>Grade:</label><input type="text" name="grade"><br>
                <label>Semester:</label>
            <select name="semester" required>
                    <option value="">--Select Sem--</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.style.display = 'none', 500);
        });
    }, 4000); // hides after 4 seconds
</script>

</body>

</html>