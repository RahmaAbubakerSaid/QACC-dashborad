<?php
require 'database.php'; // الاتصال بقاعدة البيانات

// التحقق من وجود ID للإدارة
if (isset($_POST['section_id'])) {
    $departmentId = $_POST['section_id'];

    // استعلام لحذف الإدارة بناءً على section_id
    $query = "DELETE FROM sections WHERE section_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $departmentId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'تم حذف القسم بنجاح.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء حذف القسم.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'لم يتم العثور على ID للإدارة.']);
}

$conn->close();
?>
