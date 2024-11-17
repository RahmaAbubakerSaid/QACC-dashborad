<?php
$servername = "localhost";
$username = "root"; // أو اسم المستخدم الخاص بك
$password = ""; // كلمة المرور الخاصة بك
$dbname = "db_login"; // اسم قاعدة البيانات

// إنشاء اتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

/* echo "تم الاتصال بنجاح بقاعدة البيانات"; // رسالة تأكيد

// إغلاق الاتصال
$conn->close(); */
?>

