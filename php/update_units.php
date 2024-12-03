<?php
session_start();
require 'database.php';

// استقبال البيانات من الطلب
$unitId = isset($_POST['unit_id']) ? intval($_POST['unit_id']) : null;
$unitName = isset($_POST['unit_name']) ? trim($_POST['unit_name']) : '';
$managerName = isset($_POST['manager_name']) ? trim($_POST['manager_name']) : null;
$sectionId = isset($_POST['section_id']) ? intval($_POST['section_id']) : null;
$updatedBy = isset($_SESSION['username']) ? $_SESSION['username'] : null; // افترض أن اسم المستخدم مخزن في الجلسة

// التحقق من البيانات
if (empty($unitId)) {
    echo json_encode(['success' => false, 'message' => 'الوحدة غير معروفة.']);
    exit();
}

if (empty($unitName)) {
    echo json_encode(['success' => false, 'message' => 'يرجى إدخال اسم الوحدة.']);
    exit();
}

if (empty($sectionId)) {
    echo json_encode(['success' => false, 'message' => 'يرجى تحديد القسم الذي تنتمي إليه الوحدة.']);
    exit();
}

if (empty($updatedBy)) {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ: اسم المستخدم غير متوفر.']);
    exit();
}

// تنفيذ عملية التعديل
$stmt = $conn->prepare("
    UPDATE units 
    SET unit_name = ?, manager_name = ?, section_id = ?, updated_at = NOW(), updated_by = ? 
    WHERE unit_id = ?
");
$stmt->bind_param("ssisi", $unitName, $managerName, $sectionId, $updatedBy, $unitId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء تعديل الوحدة.']);
}

$stmt->close();
$conn->close();

?>
