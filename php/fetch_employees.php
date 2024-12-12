<?php
require 'database.php'; // الاتصال بقاعدة البيانات

// استعلام لجلب أسماء الموظفين من جدول employees
$query = "SELECT name FROM employees";
$result = $conn->query($query);

$options = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // إنشاء عنصر خيار لكل اسم موظف
        $options .= "<option value='" . htmlspecialchars($row['name']) . "'>" . htmlspecialchars($row['name']) . "</option>";
    }
} else {
    $options .= "<option value=''>لا توجد أسماء متاحة</option>";
}

$conn->close();
echo $options;

?>
