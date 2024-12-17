<?php
// الاتصال بقاعدة البيانات
require 'database.php';  // تأكد من وجود الاتصال بقاعدة البيانات

// التحقق من طريقة الطلب POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // الحصول على البيانات من الطلب
    $created_by = $_POST['created_by'];

    // التعامل مع الملفات
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/QACC-dashborad/ads/';  // المجلد الذي سيتم تخزين الصور فيه
    $uploaded_files = [];  // مصفوفة لحفظ الملفات المحملة

    // عنوان URL للوصول إلى المجلد عبر الإنترنت
    $base_url = 'http://localhost/QACC-dashborad/ads/'; // رابط الوصول للمجلد عبر الإنترنت

    // التحقق من الملفات المحملة
    if (isset($_FILES['ad_image']) && is_array($_FILES['ad_image']['name'])) {
        $file_count = count($_FILES['ad_image']['name']);
        for ($i = 0; $i < $file_count; $i++) {
            $file_tmp_name = $_FILES['ad_image']['tmp_name'][$i];
            $file_name = $_FILES['ad_image']['name'][$i]; // استخدام اسم الملف كما هو دون إضافة رقم الوقت
            $file_path = $upload_dir . basename($file_name);
            $file_url = $base_url . basename($file_name); // الرابط الكامل للصورة

            // التأكد من وجود المجلد ورفع الصورة
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // تحريك الملف إلى مجلد التحميل
            if (move_uploaded_file($file_tmp_name, $file_path)) {
                // إدخال البيانات في جدول ads لكل صورة
                $stmt = $conn->prepare("INSERT INTO ads (ad_image, created_by) VALUES (?, ?)");
                $stmt->bind_param("ss", $file_url, $created_by);

                // تنفيذ العبارة
                if (!$stmt->execute()) {
                    echo json_encode(['success' => false, 'message' => 'خطأ في قاعدة البيانات: ' . $stmt->error]);
                    exit;
                }

                // إغلاق العبارة
                $stmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'فشل في رفع الملف: ' . $file_name]);
                exit;
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'لم يتم اختيار أي ملفات.']);
        exit;
    }

    // إذا تم إضافة البيانات بنجاح
    echo json_encode(['success' => true]);

} else {
    echo json_encode(['success' => false, 'message' => 'طريقة الطلب غير صالحة.']);
}

// إغلاق الاتصال
$conn->close();
?>
