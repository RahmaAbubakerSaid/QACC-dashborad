<?php
require 'database.php';

// استعلام لتحميل جميع الإدارات
$query = "SELECT department_id, department_name FROM departments";
$result = mysqli_query($conn, $query);

$departments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $departments[] = $row;
}

echo json_encode($departments);
?>