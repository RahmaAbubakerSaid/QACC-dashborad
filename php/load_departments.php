<?php
require 'database.php';

$query = "SELECT department_id, department_name FROM departments";
$result = $conn->query($query);

$options = '<option value="">اختر الإدارة</option>';
while ($row = $result->fetch_assoc()) {
    $options .= '<option value="' . $row['department_id'] . '">' . $row['department_name'] . '</option>';
}

echo $options;
?>
