<?php
session_start();
require_once 'config.php';

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Process form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['student_name'];
        $semester = $_POST['sem'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $dept_id = $_POST['department_id'];

        $stmt = $conn->prepare("UPDATE student SET st_name = ?, semester = ?, dob = ?, email = ?, dept_id = ? WHERE st_id = ?");
        $stmt->bind_param("ssssss", $name, $semester, $dob, $email, $dept_id, $student_id);
        

        if ($stmt->execute()) {
            header("Location: student_view.php?message=Student+updated+successfully");
            exit();
        } else {
            echo "Error updating student: " . $conn->error;
        }
    }

    // Fetch student data
    $stmt = $conn->prepare("SELECT * FROM student WHERE st_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!$student) {
        echo "Student not found.";
        exit();
    }

    // Fetch department list
    $departments = $conn->query("SELECT * FROM department");

} else {
    echo "Invalid request: No student ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="container">
    <div class="form-box1" id="student">
<form method="POST">
<h2>Update Student</h2>
    <label>Name:</label>
    <input type="text" name="student_name" value="<?php echo htmlspecialchars($student['st_name']); ?>" required><br><br>

    <label>Semester:</label>
    <input type="text" name="sem" value="<?php echo htmlspecialchars($student['semester']); ?>" required><br><br>
    

    <label>Date of Birth:</label>
    <input type="date" name="dob" value="<?php echo htmlspecialchars($student['dob']); ?>" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br><br>

    <label>Department:</label>
<select name="department_id" required>
    <option value="">-- Select Department --</option>
    <?php while ($dept = $departments->fetch_assoc()): ?>
        <option value="<?php echo $dept['department_id']; ?>" 
            <?php if ($dept['department_id'] == $student['dept_id']) echo 'selected'; ?>>
            <?php echo htmlspecialchars($dept['department_name']); ?>
        </option>
    <?php endwhile; ?>
</select><br>


    <button type="submit">Update</button>
</form>
</div>
</div>

</body>
</html>
