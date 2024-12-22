<?php
include 'database.php';

$data = json_decode(file_get_contents('php://input'), true);
$entity_number = $data['number'];
$entity_name = $data['name'];
$created_by = $data['username'];


try {
    // تحقق من وجود القيمة مسبقًا
    $check_sql = "SELECT * FROM entities WHERE entity_number = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("s", $entity_number);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'الرقم المدخل موجود بالفعل!']);
    } else {
        // إعداد استعلام الإدخال
        $stmt = $conn->prepare("INSERT INTO entities (entity_number, entity_name, created_by) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $entity_number, $entity_name, $created_by);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'تمت إضافة الجهة بنجاح!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء الحفظ: ' . $conn->error]);
        }

        $stmt->close();
    }

    $stmt_check->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'خطأ: ' . $e->getMessage()]);
}

$conn->close(); 
?>
