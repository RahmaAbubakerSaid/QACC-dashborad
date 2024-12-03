<?php
require 'database.php';

$department_id = $_GET['department_id'];

$query = "SELECT section_id, section_name FROM sections WHERE department_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $department_id);
$stmt->execute();
$result = $stmt->get_result();

$options = '<option value="">اختر القسم</option>';
while ($row = $result->fetch_assoc()) {
    $options .= '<option value="' . $row['section_id'] . '">' . $row['section_name'] . '</option>';
}

echo $options;
?>
