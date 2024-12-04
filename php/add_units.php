<?php
session_start();
require 'database.php';

// استقبال البيانات من الطلب
$unitName = isset($_POST['unit_name']) ? trim($_POST['unit_name']) : '';
$managerName = isset($_POST['manager_name']) ? trim($_POST['manager_name']) : null;
$sectionId = isset($_POST['section_id']) ? intval($_POST['section_id']) : null;
$createdBy = isset($_SESSION['username']) ? $_SESSION['username'] : null; // افترض أن اسم المستخدم مخزن في الجلسة

// التحقق من البيانات
if (empty($unitName)) {
    echo json_encode(['success' => false, 'message' => 'يرجى إدخال اسم الوحدة.']);
    exit();
}

if (empty($sectionId)) {
    echo json_encode(['success' => false, 'message' => 'يرجى تحديد القسم الذي تنتمي إليه الوحدة.']);
    exit();
}

if (empty($createdBy)) {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ: اسم المستخدم غير متوفر.']);
    exit();
}

// التحقق من عدم وجود الوحدة مسبقًا
$checkStmt = $conn->prepare("
    SELECT COUNT(*) AS count 
    FROM units 
    WHERE unit_name = ? AND section_id = ?
");
$checkStmt->bind_param("si", $unitName, $sectionId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();
$row = $checkResult->fetch_assoc();

if ($row['count'] > 0) {
    echo json_encode(['success' => false, 'message' => 'الوحدة موجودة مسبقًا في هذا القسم.']);
    $checkStmt->close();
    $conn->close();
    exit();
}

$checkStmt->close();

// تنفيذ عملية الإضافة
$stmt = $conn->prepare("
    INSERT INTO units (unit_name, manager_name, section_id, created_by) 
    VALUES (?, ?, ?, ?)
");
$stmt->bind_param("ssis", $unitName, $managerName, $sectionId, $createdBy);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'تمت إضافة الوحدة بنجاح.']);
} else {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء إضافة الوحدة.']);
}

$stmt->close();
$conn->close();
?>
