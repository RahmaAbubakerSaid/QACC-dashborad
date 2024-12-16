<?php
// الاتصال بقاعدة البيانات
include 'database.php';

// قراءة القيم المرسلة عبر GET
$departmentId = isset($_GET['department_id']) ? $_GET['department_id'] : '';
$sectionId = isset($_GET['section_id']) ? $_GET['section_id'] : '';
$unitId = isset($_GET['unit_id']) ? $_GET['unit_id'] : '';
$officeId = isset($_GET['office_id']) ? $_GET['office_id'] : '';

// بناء الاستعلام الأساسي
$query = "
    SELECT 
        e.id, 
        e.employee_number, 
        e.name, 
        e.position, 
        e.gender, 
        e.department, 
        e.division AS section, 
        e.unit, 
        e.office, 
        d.department_name, 
        s.section_name, 
        u.unit_name, 
        o.office_name
    FROM employees e
    LEFT JOIN departments d ON e.department = d.department_id
    LEFT JOIN sections s ON e.division = s.section_id
    LEFT JOIN units u ON e.unit = u.unit_id
    LEFT JOIN offices o ON e.office = o.office_id
    WHERE 1=1
";

// إضافة شروط التصفية حسب الاختيارات
if (!empty($departmentId)) {
    $query .= " AND e.department = '" . $conn->real_escape_string($departmentId) . "'";
}
if (!empty($sectionId)) {
    $query .= " AND e.division = '" . $conn->real_escape_string($sectionId) . "'";
}
if (!empty($unitId)) {
    $query .= " AND e.unit = '" . $conn->real_escape_string($unitId) . "'";
}
if (!empty($officeId)) {
    $query .= " AND e.office = '" . $conn->real_escape_string($officeId) . "'";
}

// تنفيذ الاستعلام
$result = $conn->query($query);
$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'id' => $row['id'],
            'employee_number' => $row['employee_number'],
            'name' => $row['name'],
            'position' => $row['position'],
            'gender' => $row['gender'],
            'department' => $row['department_name'],
            'section' => $row['section_name'],
            'unit' => $row['unit_name'],
            'office' => $row['office_name'],
        ];
    }
}

// إرجاع البيانات بصيغة JSON
header('Content-Type: application/json');
echo json_encode($data);
?>