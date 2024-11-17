<?php
// الاتصال بقاعدة البيانات
require 'database.php';  // تأكد من وجود الاتصال بقاعدة البيانات

// التحقق من طريقة الطلب GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // الحصول على معرف الموظف من الطلب
    $employee_id = intval($_GET['id']);

    // استعلام لجلب بيانات الفئة، تاريخ الإرسال، واسم الملف و المسار من جدول employee_files
    $stmt = $conn->prepare("SELECT category, send_date, file_name, file_path FROM employee_files WHERE employee_id = ?");
    $stmt->bind_param("i", $employee_id);  // ربط الـ employee_id بالاستعلام

    // تنفيذ الاستعلام
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $employee_files = [];

        // تحويل البيانات المسترجعة إلى مصفوفة
        while ($row = $result->fetch_assoc()) {
            $employee_files[] = $row;
        }

        // إذا كانت هناك ملفات، إرسال البيانات بصيغة JSON
        if (empty($employee_files)) {
            echo json_encode(['success' => false, 'message' => 'يظهر أنه حتى اللحظة الحالية لم يتم تسجيل أي ملفات لهذا الموظف.']);
        } else {
            echo json_encode(['success' => true, 'files' => $employee_files]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'فشل في استرجاع البيانات']);
    }

    // إغلاق الاتصال
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'طريقة الطلب غير صالحة.']);
}
?>

