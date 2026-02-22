<?php
session_start();
require_once 'config.php';

$selected_sem = null;
$selected_st = null;
$students = [];
$books = [];
$student_info = [];

// Fetch all semesters
$semesters_result = $conn->query("SELECT DISTINCT semester FROM student ORDER BY semester ASC");

// Step 1: If semester is selected, fetch students who have issued books
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['semester'])) {
    $selected_sem = $_POST['semester'];

    $stmt = $conn->prepare("
        SELECT DISTINCT s.st_id, s.st_name
        FROM student s
        JOIN library l ON s.st_id = l.st_id
        WHERE s.semester = ?
    ");
    $stmt->bind_param("i", $selected_sem);
    $stmt->execute();
    $students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Step 2: If student is selected, fetch student info and issued books
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['st_id'])) {
    $selected_st = $_POST['st_id'];

    // Student info
    $stmt = $conn->prepare("SELECT st_id, st_name, semester FROM student WHERE st_id = ?");
    $stmt->bind_param("s", $selected_st);
    $stmt->execute();
    $student_info = $stmt->get_result()->fetch_assoc();

    // Issued books
    $stmt2 = $conn->prepare("SELECT lib_id, book_name, issue_date, is_submitted FROM library WHERE st_id = ?");
    $stmt2->bind_param("s", $selected_st);
    $stmt2->execute();
    $books = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Library Book Management</title>
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
    <h2>Library Book Management</h2>

    <!-- Step 1 & 2: Semester & Student Selection -->
     
<div class="container">
    <div class="form-box1">
    <form method="POST">
        <label for="semester">Semester:</label>
        <select name="semester" required onchange="this.form.submit()">
            <option value="">--Select Semester--</option>
            <?php while ($row = $semesters_result->fetch_assoc()): ?>
                <option value="<?php echo $row['semester']; ?>"
                    <?php echo ($selected_sem == $row['semester']) ? 'selected' : ''; ?>>
                    <?php echo $row['semester']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="st_id">Student USN:</label>
        <select name="st_id" required>
            <option value="">--Select Student--</option>
            <?php foreach ($students as $student): ?>
                <option value="<?php echo $student['st_id']; ?>"
                    <?php echo ($selected_st == $student['st_id']) ? 'selected' : ''; ?>>
                    <?php echo $student['st_id'] . " - " . htmlspecialchars($student['st_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">View Books</button>
    </form>
    </div>
    </div>

    <?php if ($student_info): ?>
        <h3>Student Info</h3>
        <p><strong>USN:</strong> <?php echo $student_info['st_id']; ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($student_info['st_name']); ?></p>
        <p><strong>Semester:</strong> <?php echo $student_info['semester']; ?></p>

        <h3>Issued Books</h3>
        <?php if (count($books) > 0): ?>
            <table border="1" cellpadding="10" cellspacing="0" style="width:100%; background:#fff;">
                <thead style="background-color:#7494ec; color:white;">
                    <tr>
                        <th>Lib ID</th>
                        <th>Book Name</th>
                        <th>Issue Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?php echo $book['lib_id']; ?></td>
                            <td><?php echo htmlspecialchars($book['book_name']); ?></td>
                            <td><?php echo $book['issue_date']; ?></td>
                            <td><?php echo $book['is_submitted'] ? 'Submitted' : 'Not Submitted'; ?></td>
                            <td>
                                <?php if (!$book['is_submitted']): ?>
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="st_id" value="<?php echo $selected_st; ?>">
                                        <input type="hidden" name="semester" value="<?php echo $selected_sem; ?>">
                                        <input type="hidden" name="lib_id" value="<?php echo $book['lib_id']; ?>">
                                        <button type="submit" name="mark_submitted">Mark as Returned</button>
                                    </form>
                                <?php else: ?>
                                    <span>Already Returned</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No books issued for this student.</p>
        <?php endif; ?>
    <?php endif; ?>

</div>

<?php
// Step 4: Handle mark as returned action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_submitted']) && isset($_POST['lib_id'])) {
    $lib_id = $_POST['lib_id'];
    $stmt = $conn->prepare("UPDATE library SET is_submitted = 1 WHERE lib_id = ?");
    $stmt->bind_param("s", $lib_id);
    $stmt->execute();

    // Refresh page with same student & semester selected
    $semester = $_POST['semester'];
    $st_id = $_POST['st_id'];
    echo "<script>window.location.href='library_view.php?semester=$semester&st_id=$st_id';</script>";
    exit();
}
?>

</body>
</html>
