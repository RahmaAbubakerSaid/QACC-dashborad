<?php
session_start();
require 'database.php'; // ملف الاتصال بقاعدة البيانات

// تحديد نوع المحتوى كـ JSON
header('Content-Type: application/json');

// استعلام لاسترجاع جميع بيانات الموظفين مع أسماء الإدارات والأقسام والوحدات
$sql = "
    SELECT 
        employees.*, 
        IFNULL(departments.department_name, 'لا يوجد') AS department,
        IFNULL(sections.section_name, 'لا يوجد') AS division,
        IFNULL(units.unit_name, 'لا يوجد') AS unit,
        IFNULL(offices.office_name, 'لا يوجد') AS office
    FROM employees
    LEFT JOIN departments ON employees.department = departments.department_id
    LEFT JOIN sections ON employees.division = sections.section_id
    LEFT JOIN units ON employees.unit = units.unit_id
    LEFT JOIN offices ON employees.office = offices.office_id;
";

$result = $conn->query($sql);

// تحقق من وجود بيانات
$employees = [];
if ($result->num_rows > 0) {
    // تخزين جميع البيانات في مصفوفة
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
    echo json_encode(["success" => true, "employees" => $employees]);
} else {
    echo json_encode(["success" => false, "message" => "لا توجد بيانات"]);
}

// إغلاق الاتصال
$conn->close();
?>
