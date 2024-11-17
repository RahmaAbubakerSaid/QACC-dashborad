<?php
// استدعاء ملف الاتصال بقاعدة البيانات
include 'database.php';

// التحقق من وجود المعامل 'id' في الطلب
if (isset($_GET['id'])) {
    $employeeId = $_GET['id'];

    // استعلام لاسترجاع بيانات الموظف من قاعدة البيانات
    $query = "SELECT * FROM employees WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employeeId);  // ربط المعامل id بالاستعلام
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // جلب البيانات
        $employee = $result->fetch_assoc();

        // إرجاع البيانات بتنسيق JSON
        echo json_encode([
            'success' => true,
            'employee' => $employee
        ]);
    } else {
        // في حالة عدم العثور على الموظف
        echo json_encode([
            'success' => false,
            'message' => 'Employee not found'
        ]);
    }

    // إغلاق الاتصال
    $stmt->close();
    $conn->close();
} else {
    // في حالة عدم وجود المعامل 'id'
    echo json_encode([
        'success' => false,
        'message' => 'Employee ID is required'
    ]);
}
?>
