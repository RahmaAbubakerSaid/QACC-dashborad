<?php
session_start();
require 'database.php'; // الاتصال بقاعدة البيانات

// إعداد الهيدر لإرجاع JSON
header('Content-Type: application/json');

// قراءة البيانات المرسلة من الطلب
$departmentName = isset($_POST['department_name']) ? trim($_POST['department_name']) : '';
$managerName = isset($_POST['manager_name']) ? trim($_POST['manager_name']) : null;
$createdBy = isset($_SESSION['username']) ? $_SESSION['username'] : ''; // اسم المستخدم من الجلسة
$createdAt = date("Y-m-d H:i:s"); // تاريخ الإضافة

// التحقق من اسم الإدارة فقط
if (empty($departmentName)) {
    echo json_encode(['success' => false, 'message' => 'يرجى إدخال اسم الإدارة.']);
    exit();
}

// التحقق مما إذا كانت الإدارة موجودة بالفعل
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM departments WHERE department_name = ?");
$checkStmt->bind_param("s", $departmentName);
$checkStmt->execute();
$checkStmt->bind_result($count);
$checkStmt->fetch();
$checkStmt->close();

if ($count > 0) {
    echo json_encode(['success' => false, 'message' => 'الإدارة موجودة بالفعل.']);
    exit();
}

// تحضير استعلام الإدخال إذا لم تكن الإدارة موجودة
$stmt = $conn->prepare("INSERT INTO departments (department_name, manager_name, created_at, created_by) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $departmentName, $managerName, $createdAt, $createdBy);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'تمت إضافة الإدارة بنجاح.']);
} else {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء إضافة الإدارة.']);
}

$stmt->close();
$conn->close();
?>
