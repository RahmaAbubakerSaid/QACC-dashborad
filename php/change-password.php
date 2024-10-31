<?php
session_start();
require 'database.php'; // ملف الاتصال بقاعدة البيانات

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = isset($_POST['current_password']) ? trim($_POST['current_password']) : '';
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

    // التحقق من وجود بيانات المدخلات
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        echo json_encode(['success' => false, 'message' => 'يرجى ملء جميع الحقول.']);
        exit();
    }

    if ($new_password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => 'كلمات المرور الجديدة غير متطابقة.']);
        exit();
    }

    // استعلام للتحقق من كلمة المرور الحالية
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($stored_password);
            $stmt->fetch();

            // التحقق من كلمة المرور الحالية
            if (password_verify($current_password, $stored_password)) { // استخدام password_verify
                // تشفير كلمة المرور الجديدة
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                // تحديث كلمة المرور
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
                if ($stmt) {
                    $stmt->bind_param("ss", $hashed_new_password, $username); // استخدم كلمة المرور المشفرة
                    $stmt->execute();
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'حدث خطأ في الاتصال بقاعدة البيانات.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'كلمة المرور الحالية غير صحيحة.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'اسم المستخدم غير موجود.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'حدث خطأ في الاتصال بقاعدة البيانات.']);
    }
}

$conn->close();
?>