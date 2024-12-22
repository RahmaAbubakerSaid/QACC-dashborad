<?php
// تضمين الاتصال بقاعدة البيانات
include 'database.php';

// الحصول على البيانات من الطلب
$data = json_decode(file_get_contents('php://input'), true);
$entityId = $data['id'];  // تأكد من استخدام id هنا

// إعداد وإجراء عملية الحذف
$stmt = $conn->prepare("DELETE FROM entities WHERE id = ?");
$stmt->bind_param("s", $entityId);  // تأكد من استخدام id هنا بدلاً من number

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'لم يتم العثور على الجهة']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء الحذف: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
