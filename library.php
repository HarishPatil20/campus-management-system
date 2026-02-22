<?php
session_start();
require_once 'config.php'; // Include your database connection file

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}


$next_issue_id = '';
$result = $conn->query("SHOW TABLE STATUS LIKE 'library'");
if ($row = $result->fetch_assoc()) {
    $next_issue_id = $row['Auto_increment'];
}

$students = $conn->query("SELECT st_id, st_name FROM student");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Library Form</title>
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
            <li><a href="#">Library</a></li>
            <li><a href="hostel.php">Hostel</a></li>
            <li><button onclick="window.location.href='logout.php'" class="logout-btn">Logout</button></li>
          </ul>
        </nav>
      </header>
    <div class="container">
        <div class="form-box1" id="student">
            <form action="library_details.php" method="post">
                <h1>Library</h1>

                <?php if (isset($_SESSION['success_msg'])): ?>
                  <div class="alert success">
                <?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
                  </div>
                <?php endif; ?>

              <?php if (isset($_SESSION['book_error'])): ?>
            <div class="alert error">
            <?php echo $_SESSION['book_error']; unset($_SESSION['book_error']); ?>
            </div>
            <?php endif; ?>
            <label>Issue ID:</label>
<input type="text" name="issue_id" value="<?php echo $next_issue_id; ?>" readonly><br>

                <label>Library ID:</label><input type="text" name="lib_id"><br>
                <label>Student ID:</label>
                <select name="student_id" class="student-dropdown" required>
                    <option value="">Select Student</option>
                      <?php while ($student = $students->fetch_assoc()): ?>
                    <option value="<?php echo $student['st_id']; ?>">
                      <?php echo htmlspecialchars($student['st_name'] . " (" . $student['st_id'] . ")"); ?>
                    </option>
                      <?php endwhile; ?>
                  </select><br>
                <label>Book ID:</label><input type="text" name="book_id"><br>
                <label>Book Name:</label><input type="text" name="book_name"><br>  
                <label>Issue Date:</label><input type="date" name="issue_date"><br>  

                <button type="submit">Submit</button>
                <button type="button" onclick="window.location.href='library_select.php'" class="view-btn">View</button>
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