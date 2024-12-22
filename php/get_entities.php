<?php
include 'database.php';

$sql = "SELECT id, entity_number, entity_name FROM entities";
$result = $conn->query($sql);

if ($result === false) {
    // عند حدوث خطأ في الاستعلام
    die(json_encode(['error' => 'Error executing query: ' . $conn->error]));
}

$entities = [];
if ($result->num_rows > 0) {
    // استخراج البيانات من قاعدة البيانات
    while ($row = $result->fetch_assoc()) {
        $entities[] = [
            'id' => $row['id'],
            'number' => $row['entity_number'],
            'name' => $row['entity_name']
        ];
    }
} else {
    // لا توجد بيانات في الجدول
    $entities = [];
}

// إرجاع البيانات بتنسيق JSON
echo json_encode(['entities' => $entities]);

// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>
