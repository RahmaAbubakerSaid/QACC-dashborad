<?php
// إعدادات الاتصال بقاعدة البيانات
header('Content-Type: application/json');
include 'database.php'; // قم باستيراد ملف الاتصال بقاعدة البيانات

// استعلام SQL لجلب البيانات من جدول الرسائل والموظفين
$sql = "
SELECT 
    e.name AS employee_name, 
    CASE 
        WHEN m.message_text = '' OR m.message_text IS NULL THEN 'لا يوجد نص' 
        ELSE m.message_text 
    END AS message_text,  
    CASE 
        WHEN m.file_name = '' OR m.file_name IS NULL THEN 'لا يوجد ملف' 
        ELSE m.file_name 
    END AS file_name,  -- عرض اسم الملف إذا كان فارغًا يظهر 'لا يوجد اسم ملف' 
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
