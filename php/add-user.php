<?php
session_start();
require 'database.php'; // ملف الاتصال بقاعدة البيانات

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // التحقق من وجود بيانات المدخلات
    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'يرجى ملء جميع الحقول.']);
        exit();
    }

    // تحقق من وجود المستخدم بالفعل
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'اسم المستخدم مستخدم بالفعل.']);
        exit();
    }

    // إدخال المستخدم الجديد
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($stmt) {
        // تشفير كلمة المرور
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $username, $hashed_password);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء إنشاء الحساب.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'حدث خطأ في الاتصال بقاعدة البيانات.']);
    }

    $stmt->close();
}

$conn->close();
?>