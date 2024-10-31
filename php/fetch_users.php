<?php
// لحفظ معلومات المستخدم أثناء زيارته للصفحة
session_start();
require 'database.php'; // ملف الاتصال بقاعدة البيانات


$sql = "SELECT id, username FROM users";
$result = $conn->query($sql);
$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
echo json_encode($users);
?>