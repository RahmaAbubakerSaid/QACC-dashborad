<?php
header('Content-Type: application/json');
include 'database.php'; // قم باستيراد ملف الاتصال بقاعدة البيانات

// استرجاع الرسائل من قاعدة البيانات
$sql = "SELECT m.id, m.message_text, m.employee_id, e.name AS employee_name, m.created_at 
        FROM messages m 
        INNER JOIN employees e ON m.employee_id = e.id 
        ORDER BY m.created_at DESC";
$result = $conn->query($sql);

$messages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

// إرجاع الرسائل ك JSON
echo json_encode(['success' => true, 'messages' => $messages]);
?>