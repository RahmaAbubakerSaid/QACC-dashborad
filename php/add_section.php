<?php
require 'database.php'; // الاتصال بقاعدة البيانات

// استقبال بيانات القسم
$data = json_decode(file_get_contents("php://input"), true);

$departmentId = $data['department_id'];
$sectionName = $data['section_name'];
$managerName = $data['manager_name'];
$createdBy = 'admin'; // يمكنك تعديلها لتكون المستخدم الحالي

if ($departmentId && $sectionName && $managerName) {
    $stmt = $conn->prepare("INSERT INTO sections (section_name, manager_name, department_id, created_by) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $sectionName, $managerName, $departmentId, $createdBy);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "خطأ أثناء الإضافة: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "بيانات غير مكتملة"]);
}

$conn->close();
?>
