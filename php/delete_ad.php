<?php
// الاتصال بقاعدة البيانات
require 'database.php';

// التحقق من طريقة الطلب POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // الحصول على البيانات من الطلب
    $data = json_decode(file_get_contents("php://input"), true);
    $ad_id = $data['ad_id'];
    $ad_image = $data['ad_image'];

    // حذف السجل من قاعدة البيانات
    $stmt = $conn->prepare("DELETE FROM ads WHERE id = ?");
    $stmt->bind_param("i", $ad_id);

    if ($stmt->execute()) {
        // حذف الصورة من المجلد
        $file_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($ad_image, PHP_URL_PATH);
        if (file_exists($file_path)) {
            unlink($file_path);  // حذف الملف من المجلد
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'خطأ في قاعدة البيانات: ' . $stmt->error]);
    }

    // إغلاق العبارة
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'طريقة الطلب غير صالحة.']);
}

// إغلاق الاتصال
$conn->close();
?>
