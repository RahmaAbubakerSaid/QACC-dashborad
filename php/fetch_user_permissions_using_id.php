<?php
require 'database.php';

if (isset($_GET['id'])) {
    $userId = (int)$_GET['id'];

    // استعلام لاسترجاع الصلاحيات
    $sql = "SELECT section, action FROM permissions WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    //يتم هنا إنشاء مصفوفة فارغة باسم $permissions، حيث سيتم تخزين الصلاحيات المسترجعة من قاعدة البيانات.
    $permissions = [];
    while ($row = $result->fetch_assoc()) {
        $permissions[] = $row;
    }

    // إرجاع النتيجة بتنسيق JSON
    if (count($permissions) > 0) {
        echo json_encode(['success' => true, 'permissions' => $permissions]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
}

$conn->close();
?>
