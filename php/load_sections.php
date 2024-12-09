<?php
require 'database.php';

$department_id = $_GET['department_id']; // الحصول على ID الإدارة من الاستعلام

$query = "SELECT section_id, section_name FROM sections WHERE department_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $department_id);
$stmt->execute();
$result = $stmt->get_result();

$sections = [];
while ($row = mysqli_fetch_assoc($result)) {
    $sections[] = $row;
}

echo json_encode($sections);
?>