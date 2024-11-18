<?php
// إعدادات الاتصال بقاعدة البيانات
header('Content-Type: application/json');
include 'database.php'; // قم باستيراد ملف الاتصال بقاعدة البيانات

// استعلام SQL لجلب البيانات من جدول الرسائل والموظفين
//  employee_id استعلام يجلب بيانات من جدولين يربط بينهما 
$sql = "
SELECT 
    e.name AS employee_name, 
    COALESCE(m.message_text, m.file_name, m.directory_name) AS file_column, 
    m.created_at AS sent_date, 
    CASE 
        WHEN m.read_status = 'read' THEN m.read_at 
        ELSE 'لم تتم المشاهدة'
    END AS read_date, 
    CASE 
        WHEN m.read_status = 'read' THEN 'مقروءة' 
        ELSE 'غير مقروءة' 
    END AS read_status
FROM 
    messages m
JOIN 
    employees e ON m.employee_id = e.id
";

$result = $conn->query($sql);

// التحقق من وجود نتائج
$messages = [];
if ($result->num_rows > 0) {
    // إذا كانت هناك نتائج، نقوم بإضافة البيانات إلى المصفوفة
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
} else {
    // إذا لم توجد أي نتائج، نرجع رسالة تفيد بذلك
    $messages = ["message" => "لا توجد بيانات"];
}

// إرجاع البيانات بصيغة JSON
echo json_encode($messages);

// إغلاق الاتصال
$conn->close();
?>
