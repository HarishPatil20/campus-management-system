<?php
session_start();
require_once 'config.php'; // connect to database

// Fetch departments
$departments = $conn->query("SELECT department_id, department_name FROM department");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Select Semester and Department</title>
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
    <div class="form-box1">
        <form action="student_view.php" method="GET">
            <h2>Select Semester and Department</h2>

            <label>Semester:</label>
            <select name="sem" required>
                <option value="">--Select Sem--</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select><br>

            <label>Department:</label>
            <select name="department_id" required>
                <option value="">--Select Department--</option>
                <?php while ($dept = $departments->fetch_assoc()): ?>
                    <option value="<?php echo $dept['department_id']; ?>">
                        <?php echo $dept['department_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br>

            <button type="submit" class="view-btn">View</button>

        </form>
    </div>
</div>

</body>
</html>
