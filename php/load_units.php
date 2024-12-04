<?php
require 'database.php';

$section_id = $_GET['section_id'];

$query = "SELECT unit_id, unit_name FROM units WHERE section_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $section_id);
$stmt->execute();
$result = $stmt->get_result();

$options = '<option value="">اختر الوحدة</option>';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row['unit_id'] . '">' . $row['unit_name'] . '</option>';
    }
} else {
    $options .= '<option value="">لا يوجد وحدات بهذا القسم</option>';
}

echo $options;
?>
