<?php
require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['issue_id'])) {
    $issue_id = $_POST['issue_id'];
    $conn->query("UPDATE library SET is_submitted = 0 WHERE issue_id = '$issue_id'");
    header("Location: library_view.php");
    exit();
}
?>
