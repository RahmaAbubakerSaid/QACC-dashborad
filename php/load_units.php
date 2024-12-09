<?php
require 'database.php';

$section_id = $_GET['section_id']; // الحصول على ID القسم من الاستعلام

$query = "SELECT unit_id, unit_name FROM units WHERE section_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $section_id);
$stmt->execute();
$result = $stmt->get_result();

$units = [];
while ($row = mysqli_fetch_assoc($result)) {
    $units[] = $row;
}

echo json_encode($units);
?>