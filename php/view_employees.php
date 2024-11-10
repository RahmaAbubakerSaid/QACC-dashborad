<?php
session_start();
require 'database.php'; // ملف الاتصال بقاعدة البيانات

// تحديد نوع المحتوى كـ JSON
header('Content-Type: application/json');

// استعلام لاسترجاع جميع بيانات الموظفين
$sql = "SELECT * FROM employees";  // تأكد من أن اسم الجدول صحيح
$result = $conn->query($sql);

// تحقق من وجود بيانات
$employees = [];
if ($result->num_rows > 0) {
    // تخزين جميع البيانات في مصفوفة
    while($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
    echo json_encode(["success" => true, "employees" => $employees]);
} else {
    echo json_encode(["success" => false, "message" => "لا توجد بيانات"]);
}

// إغلاق الاتصال
$conn->close();
?>
