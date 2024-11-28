<?php
session_start();
require 'database.php';

// استقبال البيانات من الطلب
$sectionId = isset($_POST['section_id']) ? intval($_POST['section_id']) : null;
$sectionName = isset($_POST['section_name']) ? trim($_POST['section_name']) : '';
$managerName = isset($_POST['manager_name']) ? trim($_POST['manager_name']) : null;
$departmentId = isset($_POST['department_id']) ? intval($_POST['department_id']) : null;
$updatedBy = isset($_SESSION['username']) ? $_SESSION['username'] : null; // افترض أن اسم المستخدم مخزن في الجلسة

// التحقق من البيانات
if (empty($sectionId)) {
    echo json_encode(['success' => false, 'message' => 'القسم غير معروف.']);
    exit();
}

if (empty($sectionName)) {
    echo json_encode(['success' => false, 'message' => 'يرجى إدخال اسم القسم.']);
    exit();
}

if (empty($departmentId)) {
    echo json_encode(['success' => false, 'message' => 'يرجى تحديد الإدارة التي ينتمي إليها القسم.']);
    exit();
}

if (empty($updatedBy)) {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ: اسم المستخدم غير متوفر.']);
    exit();
}

// تنفيذ عملية التعديل
$stmt = $conn->prepare("
    UPDATE sections 
    SET section_name = ?, manager_name = ?, department_id = ?, updated_at = NOW(), updated_by = ? 
    WHERE section_id = ?
");
$stmt->bind_param("ssisi", $sectionName, $managerName, $departmentId, $updatedBy, $sectionId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء تعديل القسم.']);
}

$stmt->close();
$conn->close();
?>
