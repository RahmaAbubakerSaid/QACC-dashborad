<?php
session_start();
require 'database.php'; // الاتصال بقاعدة البيانات


// قراءة البيانات المرسلة من الطلب
$officeName = isset($_POST['office_name']) ? trim($_POST['office_name']) : '';
$managerName = isset($_POST['manager_name']) ? trim($_POST['manager_name']) : null;
$createdBy = isset($_SESSION['username']) ? $_SESSION['username'] : ''; // اسم المستخدم من الجلسة
$createdAt = date("Y-m-d H:i:s"); // تاريخ الإضافة

// التحقق من اسم المكتب فقط
if (empty($officeName)) {
    echo json_encode(['success' => false, 'message' => 'يرجى إدخال اسم المكتب.']);
    exit();
}

// التحقق مما إذا كان المكتب موجودًا بالفعل
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM offices WHERE office_name = ?");
$checkStmt->bind_param("s", $officeName);
$checkStmt->execute();
$checkStmt->bind_result($count);
$checkStmt->fetch();
$checkStmt->close();

if ($count > 0) {
    echo json_encode(['success' => false, 'message' => 'المكتب موجود بالفعل.']);
    exit();
}

// تحضير استعلام الإدخال إذا لم يكن المكتب موجودًا
$stmt = $conn->prepare("INSERT INTO offices (office_name, manager_name, created_at, created_by) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $officeName, $managerName, $createdAt, $createdBy);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'تمت إضافة المكتب بنجاح.']);
} else {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء إضافة المكتب.']);
}

$stmt->close();
$conn->close();
?>
