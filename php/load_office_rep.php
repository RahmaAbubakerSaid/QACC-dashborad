<?php
// اتصال بقاعدة البيانات
include 'database.php'; 

$sql = "SELECT office_id, office_name FROM offices";
$result = $conn->query($sql);

$offices = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $offices[] = $row;
    }
}

// إرجاع البيانات بصيغة JSON
header('Content-Type: application/json');
echo json_encode($offices);

$conn->close();
?>
