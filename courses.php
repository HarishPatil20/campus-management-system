
<?php
session_start();
require_once 'config.php'; // Don't forget to include your database connection

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}


// Fetch departments from the department table
$departments = $conn->query("SELECT department_id, department_name FROM department");

$faculties = $conn->query("SELECT faculty_id, faculty_name FROM faculty");

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav class="navigation">
        <ul>
            <li><a href="student.php">Student</a></li>
            <li><a href="faculty.php">Faculty</a></li>
            <li><a href="#">Courses</a></li>
            <li><a href="grade.php">Grades</a></li>
            <li><a href="department.php">Department</a></li>
            <li><a href="library.php">Library</a></li>
            <li><a href="hostel.php">Hostel</a></li>
            <li><button onclick="window.location.href='logout.php'" class="logout-btn">Logout</button></li>
        </ul>
    </nav>
</header>

<div class="container">
    <div class="form-box1" id="faculty">
        <form action="course_details.php" method="post">
            <h1>Course</h1>
            <?php if (isset($_SESSION['success_msg'])): ?>
                  <div class="alert success">
                <?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
                  </div>
                <?php endif; ?>

              <?php if (isset($_SESSION['course_error'])): ?>
            <div class="alert error">
            <?php echo $_SESSION['course_error']; unset($_SESSION['course_error']); ?>
            </div>
            <?php endif; ?>

            <label>Course ID:</label>
            <input type="text" name="course_id" required><br>

            <label>Course Name:</label>
            <input type="text" name="course_name" required><br>

            <label>Credits:</label>
            <input type="text" name="credits" required><br>

            <label>Department:</label>
            <select name="department_id" required>
                <option value="">Select Department</option>
                <?php while ($dept = $departments->fetch_assoc()): ?>
                    <option value="<?php echo $dept['department_id']; ?>">
                        <?php echo htmlspecialchars($dept['department_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select><br>

            <label>Faculty:</label>
            <select name="faculty_id" required>
                <option value="">Select Faculty</option>
                     <?php while ($faculty = $faculties->fetch_assoc()): ?>
                <option value="<?php echo $faculty['faculty_id']; ?>">
                        <?php echo htmlspecialchars($faculty['faculty_name'] . " (" . $faculty['faculty_id'] . ")"); ?>
                </option>
                    <?php endwhile; ?>
            </select><br>

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

