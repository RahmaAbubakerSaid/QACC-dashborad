<?php
require 'database.php'; // الاتصال بقاعدة البيانات

// التحقق من وجود ID للإدارة
if (isset($_POST['office_id'])) {
    $officeId = $_POST['office_id'];

    // استعلام لحذف الإدارة بناءً على office_id
    $query = "DELETE FROM offices WHERE office_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $officeId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'تم حذف المكتب بنجاح.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء حذف المكتب.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'لم يتم العثور على ID للمكتب.']);
}

$conn->close();
?>
