<?php
// الاتصال بقاعدة البيانات
require 'database.php';  // تأكد من وجود الاتصال بقاعدة البيانات

// استعلام لجلب البيانات من جدول "ads"
$query = "SELECT * FROM ads";
$result = $conn->query($query);

// إنشاء مصفوفة لتخزين البيانات
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;  // إضافة البيانات إلى المصفوفة
    }
}

// إرجاع البيانات بتنسيق JSON
echo json_encode($data);

// إغلاق الاتصال
$conn->close();
?>
