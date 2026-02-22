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
    $total_students = mysqli_num_rows($result);
    if (!empty($sem) && !empty($dept_id)) {
        $stmt = $conn->prepare("SELECT * FROM student WHERE semester = ? AND dept_id = ?");
        $stmt->bind_param("ss", $sem, $dept_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $total_students = mysqli_num_rows($result);
    } else {
        $result = $conn->query("SELECT * FROM student");
        $total_students = mysqli_num_rows($result);
    }
    
} else {
    
    $result = $conn->query("SELECT * FROM student");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Students</title>
    <link rel="stylesheet" href="style.css">
     <style>
    table, th, td {
        border: 1px solid #ccc;
        border-collapse: collapse;
    }
    td, th {
        padding: 10px;
        text-align: center;
    }
    .print-button {
      display: block;
      margin: 50px auto;      /* Centers the button horizontally and adds vertical spacing */
      padding: 12px 30px;     /* Button size (you can adjust as needed) */
      background-color: #007BFF; /* Blue color */
      color: white;
      border: none;
      border-radius: 8px;     /* Rounded corners */
      font-size: 16px;
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease;
    }

    .print-button:hover {
      background-color: #0056b3; /* Darker blue on hover */
    }
  </style>
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
    <h3 >Total students in <?php echo $sem ? $sem : 'All'; ?> semester: <?php echo $total_students; ?></h3>
   <!-- <p><strong>Total Students:</strong> <?php echo $total_students; ?></p>-->

   <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; background: #fff; border-radius: 8px;">
        <thead style="background-color: #7494ec; color: white;">
            <tr>
                <th>Sl No</th> <!-- Serial number header -->
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Semester</th>
                <th>Department ID</th>
                <th>Date of Birth</th>
                <th>Email</th>
                <th>Actions</th>
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
                        <td>
    <!-- Update button -->
    <a href="update_student.php?id=<?php echo $row['st_id']; ?>" 
       style="padding: 4px 8px; font-size: 12px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px; margin-right: 5px;">
       Update
    </a>

    <!-- Delete button -->
    <a href="delete_student.php?id=<?php echo $row['st_id']; ?>" 
       onclick="return confirm('Are you sure you want to delete this student?')" 
       style="padding: 4px 8px; font-size: 12px; background-color: #f44336; color: white; text-decoration: none; border-radius: 4px;">
       Delete
    </a>
</td>

                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">No students found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
 <button class="print-button" onclick="window.print()">Print</button></div>

</body>
</html>
