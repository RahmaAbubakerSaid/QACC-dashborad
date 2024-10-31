<?php

session_start();

require 'database.php'; // الاتصال بقاعدة البيانات

$data = json_decode(file_get_contents("php://input"), true);

$userId = $data['user_id'];

$permissions = $data['permissions'];

// حذف الصلاحيات القديمة للمستخدم

$conn->query("DELETE FROM permissions WHERE user_id = $userId");

// إدخال الصلاحيات الجديدة

foreach ($permissions as $permission) {

$section = $conn->real_escape_string($permission['section']);


foreach ($permission['actions'] as $action) {

$action = $conn->real_escape_string($action);

$conn->query("INSERT INTO permissions (user_id, section, action) VALUES ($userId, '$section', '$action')");

}

}

$conn->close();
echo json_encode(['status' => 'success']);

?>