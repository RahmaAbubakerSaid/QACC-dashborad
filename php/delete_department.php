<?php
require 'database.php'; // الاتصال بقاعدة البيانات

// التحقق من وجود ID للإدارة
if (isset($_POST['department_id'])) {
    $departmentId = $_POST['department_id'];

    // استعلام لحذف الإدارة بناءً على department_id
    $query = "DELETE FROM departments WHERE department_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $departmentId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'تم حذف الإدارة بنجاح.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء حذف الإدارة.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'لم يتم العثور على ID للإدارة.']);
}

$conn->close();
?>
