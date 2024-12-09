<?php
header('Content-Type: application/json');
include 'database.php'; // قم باستيراد ملف الاتصال بقاعدة البيانات

// التحقق من وجود البيانات عبر الـ POST
if (!isset($_POST['employees'], $_POST['username'])) {
    echo json_encode(['success' => false, 'message' => 'يرجى تقديم الموظفين.']);
    exit;
}

$username = $_POST['username']; // استلام اسم المستخدم
$employees = json_decode($_POST['employees']); // تحويل بيانات الموظفين من JSON إلى مصفوفة
$message = isset($_POST['message']) ? trim($_POST['message']) : ''; // إذا لم تكن الرسالة موجودة تكون فارغة

// التحقق من وجود الموظفين
if (empty($employees)) {
    echo json_encode(['success' => false, 'message' => 'يرجى تحديد موظف واحد على الأقل.']);
    exit;
}

// إعداد العبارة لتحضير الإدخال
$stmt = $conn->prepare("INSERT INTO messages (employee_id, message_text, created_by, file_name, file_url, read_status, archive_status) VALUES (?, ?, ?, ?, ?, 'unread', 'غير مؤرشف')");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'حدث خطأ في إعداد الاستعلام.']);
    exit;
}

// مسار المجلد لتحميل الملفات
$upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/QACC-dashborad/archives/';  // المجلد الذي سيتم تخزين الملفات فيه على الخادم
$base_url = 'http://localhost/QACC-dashborad/archives/'; // استبدال الرابط ليعكس المسار الصحيح عبر الإنترنت

// التحقق من وجود ملفات مرفقة وتحميلها لجميع الموظفين
if (isset($_FILES['files']) && count($_FILES['files']['name']) > 0) {
    // التأكد من أن مجلد التحميل موجود
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);  // إنشاء المجلد إذا لم يكن موجودًا
    }

    // تحميل الملفات لجميع الموظفين
    $file_names = [];
    $file_urls = [];
    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
        $file_tmp = $_FILES['files']['tmp_name'][$i];
        $file_name = basename($_FILES['files']['name'][$i]);
        $file_url = $base_url . $file_name; // رابط الوصول إلى الملف عبر الإنترنت

        // نقل الملف إلى المجلد المناسب
        if (!move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء تحميل الملف: ' . $file_name]);
            exit;
        }

        // حفظ أسماء الملفات المرفقة
        $file_names[] = $file_name;
        $file_urls[] = $file_url;
    }
    $file_names = implode(', ', $file_names);
    $file_urls = implode(', ', $file_urls);
}

// إرسال الرسالة لجميع الموظفين
foreach ($employees as $employee_id) {
    // تحقق من أن معرف الموظف هو رقم صحيح
    if (!is_numeric($employee_id)) {
        echo json_encode(['success' => false, 'message' => 'معرف الموظف غير صحيح: ' . htmlspecialchars($employee_id)]);
        exit;
    }

    // التحقق من وجود الملف في جدول Archival
    $archive_status = 'غير مؤرشف'; // الحالة الافتراضية
    if (!empty($file_names)) {
        $file_check_stmt = $conn->prepare("SELECT COUNT(*) FROM Archival WHERE file_name = ? OR file_url = ?");
        $file_check_stmt->bind_param("ss", $file_names, $file_urls); // تحقق من الملف باستخدام الاسم أو الرابط
        $file_check_stmt->execute();
        $file_check_stmt->bind_result($count);
        $file_check_stmt->fetch();
        $file_check_stmt->close();

        // إذا تم العثور على الملف في جدول Archival، تغيير الحالة إلى "مؤرشفة"
        if ($count > 0) {
            $archive_status = 'مؤرشفة';
        }
    }

    // إذا لم يكن هناك ملفات مرفقة، فقط أرسل الرسالة بدون ملف
    if (empty($file_names)) {
        $file_names = null;
        $file_urls = null;
    }

    // إدخال الرسالة والملفات في قاعدة البيانات مع حالة الأرشفة
    $stmt->bind_param("issss", $employee_id, $message, $username, $file_names, $file_urls);
    
    // تحقق من نجاح تنفيذ الاستعلام
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء إدخال الرسالة للموظف: ' . htmlspecialchars($employee_id)]);
        exit;
    }

    // تحديث حالة الأرشفة في جدول الرسائل
    $update_stmt = $conn->prepare("UPDATE messages SET archive_status = ? WHERE file_name = ? OR file_url = ?");
    $update_stmt->bind_param("sss", $archive_status, $file_names, $file_urls);
    if (!$update_stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء تحديث حالة الأرشفة للملف: ' . htmlspecialchars($file_names)]);
        exit;
    }
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'message' => 'تم إرسال الرسالة إلى الموظفين المحددين.']);
?>
