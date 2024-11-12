<?php
// الاتصال بقاعدة البيانات
require 'database.php';  // تأكد من وجود الاتصال بقاعدة البيانات

// التحقق من طريقة الطلب POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // الحصول على معرف الموظف من الطلب
    $employee_id = intval($_POST['employee_id']);
    $category = $_POST['category'];
    $send_date = $_POST['sendDate'];
    $created_by = $_POST['created_by'];

    // التعامل مع الملفات
    $upload_dir = 'uploads/';  // المجلد الذي سيتم تخزين الصور فيه
    $uploaded_files = [];  // مصفوفة لحفظ الملفات المحملة

    // عنوان URL للوصول إلى المجلد عبر الإنترنت
    //$base_url = 'http://example.com/php/uploads/'; // استبدل هذا بعنوان موقعك الفعلي
    $base_url = 'php/uploads/'; // استبدل هذا بعنوان موقعك الفعلي


    // التحقق من الملفات المحملة
    if (isset($_FILES['images']) && is_array($_FILES['images']['name'])) {
        $file_count = count($_FILES['images']['name']);
        for ($i = 0; $i < $file_count; $i++) {
            $file_tmp_name = $_FILES['images']['tmp_name'][$i];
            $file_name = $_FILES['images']['name'][$i];
            $file_path = $upload_dir . basename($file_name);
            $file_url = $base_url . basename($file_name); // إنشاء الرابط الكامل للصورة

            // التأكد من وجود المجلد ورفع الصورة
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // تحريك الملف إلى مجلد التحميل
            if (move_uploaded_file($file_tmp_name, $file_path)) {
                // إدخال البيانات في جدول employee_files لكل صورة
                $stmt = $conn->prepare("INSERT INTO employee_files (employee_id, category, send_date, file_name, file_path, created_by) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("isssss", $employee_id, $category, $send_date, $file_name, $file_url, $created_by);

                // تنفيذ العبارة
                if (!$stmt->execute()) {
                    echo json_encode(['success' => false, 'message' => 'خطأ في قاعدة البيانات: ' . $stmt->error]);
                    exit;
                }

                // إغلاق العبارة
                $stmt->close();
            }
        }
    }

    // إذا تم إضافة الملفات بنجاح
    echo json_encode(['success' => true]);

} else {
    echo json_encode(['success' => false, 'message' => 'طريقة الطلب غير صالحة.']);
}

// إغلاق الاتصال
$conn->close();
?>
