<?php
require 'database.php'; // الاتصال بقاعدة البيانات

// استعلام لجلب المكاتب من قاعدة البيانات
$query = "SELECT office_name, manager_name FROM offices";
$result = $conn->query($query);

// التحقق من وجود بيانات
if ($result->num_rows > 0) {
    // عرض المكاتب في الجدول
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['office_name']) . "</td>";
        echo "<td>" . (!empty($row['manager_name']) ? htmlspecialchars($row['manager_name']) : 'غير محدد') . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='2'>لا توجد مكاتب حالياً.</td></tr>";
}
$conn->close();
?>
