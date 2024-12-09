<?php
// الاتصال بقاعدة البيانات
require 'database.php';

// استعلام لجلب البيانات
$query = "SELECT employee_name, department_name, section_name, unit_name, job_title FROM employees";
$result = $conn->query($query);

// التحقق من وجود وحدات
$hasUnits = false;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['unit_name'])) {
            $hasUnits = true;
            break;
        }
    }
}

// إعادة تشغيل المؤشر للنتائج
$result->data_seek(0);

// بناء الجدول
echo '<table>';
echo '<thead>';
echo '<tr>';
echo '<th>الرقم</th>';
echo '<th>اسم الموظف</th>';
echo '<th>الإدارة</th>';
echo '<th>القسم</th>';
if ($hasUnits) {
    echo '<th>الوحدة</th>';
}
echo '<th>الوظيفة</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if ($result->num_rows > 0) {
    $counter = 1;
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $counter++ . '</td>';
        echo '<td>' . htmlspecialchars($row['employee_name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['department_name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['section_name']) . '</td>';
        if ($hasUnits) {
            echo '<td>' . (!empty($row['unit_name']) ? htmlspecialchars($row['unit_name']) : 'غير محدد') . '</td>';
        }
        echo '<td>' . htmlspecialchars($row['job_title']) . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="' . ($hasUnits ? '6' : '5') . '">لا توجد بيانات متاحة.</td></tr>';
}

echo '</tbody>';
echo '</table>';

$conn->close();
?>
