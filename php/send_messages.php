<?php
header('Content-Type: application/json');
include 'database.php'; // قم باستيراد ملف الاتصال بقاعدة البيانات

// قراءة البيانات المدخلة
$data = json_decode(file_get_contents("php://input"), true);

// التحقق من وجود بيانات الموظفين والرسالة
if (!isset($data['employees'], $data['message'], $data['username'])) {
    
    echo json_encode(['success' => false, 'message' => 'يرجى تقديم الموظفين والرسالة.']);
    exit;
}

$username = $data['username']; // استلام اسم المستخدم
$employees = $data['employees'];
$message = trim($data['message']); // إزالة المسافات البيضاء من البداية والنهاية

// التحقق من العوامل المدخلة
if (empty($employees) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'يرجى تحديد موظف واحد على الأقل وكتابة رسالة.']);
    exit;
}

// إعداد العبارة لتحضير الإدخال
$stmt = $conn->prepare("INSERT INTO messages (employee_id, message_text, created_by ) VALUES (?, ?, ?)");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ في إعداد الاستعلام.']);
    exit;
}

// إرسال الرسالة لكل موظف تم تحديده
foreach ($employees as $employee_id) {
    // تحقق من أن معرف الموظف هو رقم صحيح
    if (!is_numeric($employee_id)) {
        echo json_encode(['success' => false, 'message' => 'معرف الموظف غير صحيح: ' . htmlspecialchars($employee_id)]);
        exit;
    }
    
    $stmt->bind_param("iss", $employee_id, $message, $username);
    
    // تحقق من نجاح تنفيذ الاستعلام
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء إدخال الرسالة للموظف: ' . htmlspecialchars($employee_id)]);
        exit;
    }
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'message' => 'تم إرسال الرسالة إلى الموظفين المحددين.']);
?>