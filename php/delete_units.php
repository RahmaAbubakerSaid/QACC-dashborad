<?php
session_start();
require 'database.php'; // تأكد من أنك متصل بقاعدة البيانات

header('Content-Type: application/json'); // إجبار الاستجابة على أن تكون بصيغة JSON

// استقبال رقم الوحدة من الطلب
$unitId = isset($_POST['unit_id']) ? intval($_POST['unit_id']) : null;

if (empty($unitId)) {
    echo json_encode(['success' => false, 'message' => 'رقم الوحدة غير صالح.']);
    exit();
}

try {
    $stmt = $conn->prepare("DELETE FROM units WHERE unit_id = ?");
    $stmt->bind_param("i", $unitId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'تم حذف الوحدة بنجاح.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء حذف الوحدة.']);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'خطأ في الخادم: ' . $e->getMessage()]);
}
?>
