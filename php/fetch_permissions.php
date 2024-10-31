<?php
session_start();
require 'database.php'; // الاتصال بقاعدة البيانات

$result = $conn->query("
    SELECT p.user_id, u.username, p.section, p.action 
    FROM permissions p 
    JOIN users u ON p.user_id = u.id
");

$permissions = [];
while ($row = $result->fetch_assoc()) {
    $permissions[$row['user_id']]['username'] = $row['username'];
    $permissions[$row['user_id']]['permissions'][$row['section']][] = $row['action'];
}

$finalPermissions = [];
foreach ($permissions as $userId => $userPermissions) {
    $finalPermissions[] = [
        'user_id' => $userId,
        'username' => $userPermissions['username'],
        'permissions' => $userPermissions['permissions'],
    ];
}

$conn->close();
echo json_encode($finalPermissions);
?>