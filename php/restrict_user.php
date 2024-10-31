<?php
session_start();
require 'database.php'; // استدعاء ملف الاتصال بقاعدة البيانات

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == 'restrict') {
        $sql = "UPDATE users SET restricted = 1 WHERE id = ?";
    } elseif ($action == 'unrestrict') {
        $sql = "UPDATE users SET restricted = 0 WHERE id = ?";
    } else {
        // إذا كانت القيمة غير صحيحة، يمكن توجيه المستخدم إلى صفحة الخطأ أو التعامل معها بشكل مناسب
        exit("Invalid action");
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // إعادة التوجيه بعد التحديث
    header("Location: http://localhost/QACC-dashborad/system-administrator.html"); // استبدل "users.php" باسم الصفحة المناسبة
    exit();
}

$conn->close(); // إغلاق الاتصال بقاعدة البيانات
?>