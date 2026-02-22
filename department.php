<?php
session_start();
require_once 'config.php'; // Don't forget to include your database connection

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>department Form</title>
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
            <li><a href="#">Department</a></li>
            <li><a href="library.php">Library</a></li>
            <li><a href="hostel.php">Hostel</a></li>
            <li><button onclick="window.location.href='logout.php'" class="logout-btn">Logout</button></li>
        </ul>
    </nav>
</header>

<div class="container">
    <div class="form-box1" id="faculty">
        <form action="department_details.php" method="post">
            <h1>Department</h1>

            <?php if (isset($_SESSION['success_msg'])): ?>
                <div class="alert success">
                    <?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['department_error'])): ?>
                <div class="alert error">
                    <?php echo $_SESSION['department_error']; unset($_SESSION['department_error']); ?>
                </div>
            <?php endif; ?>

            <label>Department ID:</label>
            <input type="text" name="department_id" required><br>

            <label>Department Name:</label>
            <input type="text" name="department_name" required><br>

            <label>Department HOD:</label>
            <input type="text" name="department_hod" required><br>

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
