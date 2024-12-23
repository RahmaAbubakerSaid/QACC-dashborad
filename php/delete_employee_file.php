<?php
// الاتصال بقاعدة البيانات
require 'database.php';  // تأكد من وجود الاتصال بقاعدة البيانات

// التحقق من طريقة الطلب DELETE
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // قراءة البيانات من الطلب JSON
    $data = json_decode(file_get_contents("php://input"), true);
    $file_id = intval($data['id']);  // تأكد من أن المعرف هو عدد صحيح

    // استعلام لجلب مسار الملف من جدول employee_files
    $stmt = $conn->prepare("SELECT file_name, file_path FROM employee_files WHERE id = ?");
    $stmt->bind_param("i", $file_id);  // ربط الـ file_id بالاستعلام
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($file_name, $file_path);
    
    // إذا وجدنا الملف في قاعدة البيانات
    if ($stmt->fetch()) {
        // استعلام لحذف الملف من جدول employee_files
        $stmt_delete = $conn->prepare("DELETE FROM employee_files WHERE id = ?");
        $stmt_delete->bind_param("i", $file_id);  // ربط الـ file_id بالاستعلام

        // تنفيذ استعلام الحذف من قاعدة البيانات
        if ($stmt_delete->execute()) {
            // إذا تم الحذف بنجاح، إرسال استجابة بنجاح
            echo json_encode(['success' => true, 'message' => 'تم حذف الملف بنجاح']);
        } else {
            // إذا فشل الحذف في قاعدة البيانات، إرسال رسالة خطأ
            echo json_encode(['success' => false, 'message' => 'فشل في حذف الملف من قاعدة البيانات']);
        }

        // إغلاق الاستعلام
        $stmt_delete->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'الملف غير موجود في قاعدة البيانات']);
    }

    // إغلاق الاتصال
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'طريقة الطلب غير صالحة']);
}
?>
