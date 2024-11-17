<?php
session_start();
require 'database.php'; // الاتصال بقاعدة البيانات

try {
    // قراءة البيانات المرسلة
    $officeName = $_POST['officeName'] ?? '';
    $managerName = $_POST['managerName'] ?? null;
    $createdBy = $_POST['createdBy'] ?? '';

    // التحقق من الحقول المطلوبة
    if (empty($officeName) || empty($createdBy)) {
        echo json_encode(['success' => false, 'message' => 'يرجى ملء جميع الحقول المطلوبة.']);
        exit();
    }

    // تجهيز استعلام الإدخال
    $stmt = $conn->prepare("INSERT INTO offices (office_name, manager_name, created_at, created_by) VALUES (?, ?, NOW(), ?)");
    if (!$stmt) {
        throw new Exception("خطأ في تجهيز الاستعلام: " . $conn->error);
    }

    $stmt->bind_param("sss", $officeName, $managerName, $createdBy);

    // تنفيذ الاستعلام
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'تمت إضافة المكتب بنجاح.']);
    } else {
        throw new Exception("حدث خطأ أثناء إضافة المكتب: " . $stmt->error);
    }

    // إغلاق الاستعلام
    $stmt->close();
} catch (Exception $e) {
    // في حال حدوث خطأ يتم عرض الرسالة المناسبة
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    // إغلاق الاتصال بقاعدة البيانات
    $conn->close();
}
?>
