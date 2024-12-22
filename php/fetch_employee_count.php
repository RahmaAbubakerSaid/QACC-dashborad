<?php
// الاتصال بقاعدة البيانات
require 'database.php'; // الاتصال بقاعدة البيانات

// إعداد الهيدر لإرجاع JSON

// كتابة الاستعلام لجلب عدد الموظفين
$sql = "SELECT COUNT(*) AS employee_count FROM employees";

// تحضير الاستعلام
$stmt = $conn->prepare($sql);

// تنفيذ الاستعلام
$stmt->execute();

// ربط النتائج
$stmt->bind_result($employee_count);

// جلب النتيجة
$stmt->fetch();

// إرجاع النتيجة كـ JSON
echo json_encode(["employee_count" => $employee_count]);

// إغلاق الاتصال
$stmt->close();
$conn->close();
?>
