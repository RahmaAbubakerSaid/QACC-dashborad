<?php
session_start();
require 'database.php'; // الاتصال بقاعدة البيانات

// قراءة البيانات المرسلة من الطلب
$departmentId = isset($_POST['department_id']) ? $_POST['department_id'] : null;
$departmentName = isset($_POST['department_name']) ? trim($_POST['department_name']) : '';
$managerName = isset($_POST['manager_name']) ? trim($_POST['manager_name']) : null;
$updatedBy = isset($_SESSION['username']) ? $_SESSION['username'] : null; // افترض أن اسم المستخدم مخزن في الجلسة

// التحقق من إدخال البيانات الأساسية
if (empty($departmentId) || empty($departmentName)) {
    echo json_encode(['success' => false, 'message' => 'يرجى إدخال اسم الإدارة.']);
    exit();
}

// تحديث بيانات الإدارة
$updateStmt = $conn->prepare("UPDATE departments SET department_name = ?, manager_name = ?, updated_at = NOW(), updated_by = ? WHERE department_id = ?");
$updateStmt->bind_param("sssi", $departmentName, $managerName,$updatedBy,$departmentId);

if ($updateStmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'تم تعديل الإدارة بنجاح.']);
} else {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء تعديل الإدارة.']);
}

$updateStmt->close();
$conn->close();
?>
