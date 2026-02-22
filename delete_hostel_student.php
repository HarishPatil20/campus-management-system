<?php
require_once 'config.php';

$st_id = $_GET['st_id'] ?? '';
if($st_id) {
    $stmt = $conn->prepare("DELETE FROM hostel WHERE st_id=?");
    $stmt->bind_param("s", $st_id);
    $stmt->execute();
}

header("Location: hostel_st_select.php");
exit();
?>
