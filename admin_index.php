<?php
session_start();
require_once 'config.php';

// Get filter values from GET
$sem = isset($_GET['sem']) ? $_GET['sem'] : '';
$dept_id = isset($_GET['department_id']) ? $_GET['department_id'] : '';


// Only fetch if both are provided
if (!empty($sem) && !empty($dept_id)) {
    $stmt = $conn->prepare("SELECT * FROM student WHERE semester = ? AND dept_id = ?");
    $stmt->bind_param("ss", $sem, $dept_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // fallback if no filter
    $result = $conn->query("SELECT * FROM student");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Students</title>
    <link rel="stylesheet" href="style.css"> <!-- your same style.css -->
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
    
    <h1>Student List</h1>
    <h2>Showing Students of Semester <?php echo $sem; ?> - Department <?php echo $dept_id; ?></h2>

    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; background: #fff; border-radius: 8px;">
        <thead style="background-color: #7494ec; color: white;">
            <tr>
                <th>Sl No</th> <!-- Serial number header -->
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Semester</th>
                <th>Department ID</th>
                <th>Date of Birth</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($result) > 0): 
                $serial = 1; // Initialize serial number
                while($row = mysqli_fetch_assoc($result)): 
            ?>
                    <tr>
                        <td><?php echo $serial++; ?></td> <!-- Display serial number -->
                        <td><?php echo htmlspecialchars($row['st_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['st_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['semester']); ?></td>
                        <td><?php echo htmlspecialchars($row['dept_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['dob']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">No students found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>
