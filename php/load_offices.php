<?php
require 'database.php';

// استعلام لتحميل جميع الإدارات
$query = "SELECT office_id, office_name FROM offices";
$result = mysqli_query($conn, $query);

$offices = [];
while ($row = mysqli_fetch_assoc($result)) {
    $offices[] = $row;
}

echo json_encode($offices);
?>