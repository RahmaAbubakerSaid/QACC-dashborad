<?php
session_start();
require 'database.php';

// استقبال البيانات من الطلب
$sectionName = isset($_POST['section_name']) ? trim($_POST['section_name']) : '';
$managerName = isset($_POST['manager_name']) ? trim($_POST['manager_name']) : null;
$departmentId = isset($_POST['department_id']) ? intval($_POST['department_id']) : null;
$createdBy = isset($_SESSION['username']) ? $_SESSION['username'] : null; // افترض أن اسم المستخدم مخزن في الجلسة

// التحقق من البيانات
if (empty($sectionName)) {
    echo json_encode(['success' => false, 'message' => 'يرجى إدخال اسم القسم.']);
    exit();
}

if (empty($departmentId)) {
    echo json_encode(['success' => false, 'message' => 'يرجى تحديد الإدارة التي ينتمي إليها القسم.']);
    exit();
}

if (empty($createdBy)) {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ: اسم المستخدم غير متوفر.']);
    exit();
}

// تنفيذ عملية الإضافة
$stmt = $conn->prepare("
    INSERT INTO sections (section_name, manager_name, department_id, created_by) 
    VALUES (?, ?, ?, ?)
");
$stmt->bind_param("ssis", $sectionName, $managerName, $departmentId, $createdBy);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء إضافة القسم.']);
}

$stmt->close();
$conn->close();
?>
