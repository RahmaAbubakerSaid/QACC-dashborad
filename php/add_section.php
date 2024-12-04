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

// التحقق من عدم وجود القسم مسبقًا
$checkStmt = $conn->prepare("
    SELECT COUNT(*) AS count 
    FROM sections 
    WHERE section_name = ? AND department_id = ?
");
$checkStmt->bind_param("si", $sectionName, $departmentId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();
$row = $checkResult->fetch_assoc();

if ($row['count'] > 0) {
    echo json_encode(['success' => false, 'message' => 'القسم موجود مسبقًا في هذه الإدارة.']);
    $checkStmt->close();
    $conn->close();
    exit();
}

$checkStmt->close();

// تنفيذ عملية الإضافة
$stmt = $conn->prepare("
    INSERT INTO sections (section_name, manager_name, department_id, created_by) 
    VALUES (?, ?, ?, ?)
");
$stmt->bind_param("ssis", $sectionName, $managerName, $departmentId, $createdBy);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'تمت إضافة القسم بنجاح.']);
} else {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء إضافة القسم.']);
}

$stmt->close();
$conn->close();
?>
