<?php
// الاتصال بقاعدة البيانات
include 'database.php'; // ملف الاتصال بقاعدة البيانات

// استعلام لجلب بيانات الإدارات مع العدد المطلوب
$query = "
    SELECT 
        d.department_id, 
        d.department_name, 
        COUNT(DISTINCT e.id) AS employee_count, 
        COUNT(DISTINCT s.section_id) AS section_count, 
        COUNT(DISTINCT u.unit_id) AS unit_count
    FROM departments d
    LEFT JOIN employees e ON d.department_id = e.department
    LEFT JOIN sections s ON d.department_id = s.department_id
    LEFT JOIN units u ON s.section_id = u.section_id
    GROUP BY d.department_id, d.department_name;
";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $departments = $result->fetch_all(MYSQLI_ASSOC);
    // إعادة البيانات كـ JSON
    echo json_encode($departments);
} else {
    echo json_encode([]);
}

// إغلاق الاتصال
$conn->close();
?>
