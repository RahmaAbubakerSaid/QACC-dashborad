<?php
header('Content-Type: application/json');
require 'database.php'; // تأكد من استيراد الاتصال بقاعدة البيانات

// تحقق من أن الطلب هو DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    $messageId = $input['id'];

    // قم بإعداد استعلام SQL لحذف الرسالة
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param("i", $messageId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'فشل حذف الرسالة.']);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'طريقة الطلب غير مدعومة.']);
}
?>