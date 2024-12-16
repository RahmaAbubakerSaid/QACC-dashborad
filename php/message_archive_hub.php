<?php
header('Content-Type: application/json');

// الاتصال بقاعدة البيانات
require 'database.php'; // ملف الاتصال بقاعدة البيانات

// استعلام لجلب البيانات
$sql = "SELECT * FROM Archival";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

// إرجاع البيانات بصيغة JSON
echo json_encode($data);
?>
