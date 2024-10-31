<?php
session_start();
require 'database.php'; // استدعاء ملف الاتصال بقاعدة البيانات

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); // تأكد من أن المعرف هو عدد صحيح

    // استعلام الحذف
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $_SESSION['message'] = "تم حذف المستخدم بنجاح.";
    } else {
        $_SESSION['message'] = "حدث خطأ أثناء حذف المستخدم.";
    }

    $stmt->close();
} else {
    $_SESSION['message'] = "معرف المستخدم غير صحيح.";
}

$conn->close(); // إغلاق الاتصال بقاعدة البيانات

// إعادة التوجيه إلى الصفحة السابقة
header("Location: http://localhost/QACC-dashborad/system-administrator.html"); // استبدل your_user_page.php باسم الصفحة المناسبة
exit();
?>