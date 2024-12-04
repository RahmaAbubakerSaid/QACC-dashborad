<?php
session_start();
require 'database.php'; // الاتصال بقاعدة البيانات

// قراءة البيانات من الطلب
$officeId = isset($_POST['office_id']) ? intval($_POST['office_id']) : null;
$officeName = isset($_POST['office_name']) ? trim($_POST['office_name']) : '';
$managerName = isset($_POST['manager_name']) ? trim($_POST['manager_name']) : null;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : ''; // اسم المستخدم من الجلسة

// التحقق من القيم المدخلة
if (empty($officeId) || empty($officeName)) {
    echo json_encode(['success' => false, 'message' => 'يرجى إدخال اسم المكتب ومعرفه.']);
    exit();
}

// إعداد استعلام التحديث
$updateStmt = $conn->prepare("
    UPDATE offices 
    SET office_name = ?, manager_name = ?, updated_by = ?, updated_at = NOW() 
    WHERE office_id = ?
");
$updateStmt->bind_param("sssi", $officeName, $managerName, $username, $officeId);

// تنفيذ استعلام التحديث
if ($updateStmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'تم تعديل المكتب بنجاح.']);
} else {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء تعديل المكتب.']);
}

// إغلاق الاتصال
$updateStmt->close();
$conn->close();
?>
