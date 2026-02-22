<?php
session_start();
require_once 'config.php';

// Fetch issued book records with student name
$query = "SELECT l.issue_id, l.book_name, l.issue_date, l.is_submitted, s.st_name
          FROM library l
          JOIN student s ON l.st_id = s.st_id";
$result = $conn->query($query);
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
    <h2>Library Book Issue Records</h2>

    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; background: #fff;">
        <thead style="background-color: #7494ec; color: white;">
            <tr>
                <th>Issue ID</th>
                <th>Book Name</th>
                <th>Issue Date</th>
                <th>Student Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['issue_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                        <td><?php echo $row['issue_date']; ?></td>
                        <td><?php echo htmlspecialchars($row['st_name']); ?></td>
                        <td><?php echo $row['is_submitted'] ? 'Submitted' : 'Not Submitted'; ?></td>
                        <td>
                            <?php if ($row['is_submitted']): ?>
                                <form method="POST" action="mark_not_submitted.php">
                                    <input type="hidden" name="issue_id" value="<?php echo $row['issue_id']; ?>">
                                    <button type="submit">Mark Not Submitted</button>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="mark_submitted.php">
                                    <input type="hidden" name="issue_id" value="<?php echo $row['issue_id']; ?>">
                                    <button type="submit">Mark Submitted</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">No records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
