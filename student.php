<?php
session_start();
require_once 'config.php'; 

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}




$departments = $conn->query("SELECT department_id, department_name FROM department");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Form</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

<header>
    <nav class="navigation">
        <ul>
            <li><a href="#">Student</a></li>
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
    <div class="form-box1" id="student">
        <form action="student_detailes.php" method="POST">
            <h1>Student</h1>

            <?php if (isset($_SESSION['success_msg'])): ?>
                <div class="alert success">
                    <?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['stregister_error'])): ?>
                <div class="alert error">
                    <?php echo $_SESSION['stregister_error']; unset($_SESSION['stregister_error']); ?>
                </div>
            <?php endif; ?>

            

            <label>Student ID:</label>
            <input type="text" name="student_id" required><br>

            <label>Student Name:</label>
            <input type="text" name="student_name" required><br>

            <label>Semister:</label>
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
                </select>

            <label>Department:</label>
            <select name="department_id" required>
                <option value="">-- Select Department --</option>
                <?php while ($dept = $departments->fetch_assoc()): ?>
                    <option value="<?php echo $dept['department_id']; ?>">
                        <?php echo $dept['department_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br>

            <label>Date of Birth:</label>
            <input type="date" name="dob" required><br>

            <label>Email:</label>
            <input type="email" name="email" required><br>

            <button type="submit">Submit</button>
            <button type="button" onclick="window.location.href='student_select.php'" class="view-btn">View</button>


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
    }, 4000); 
</script>

</body>
</html>