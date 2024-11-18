<?php
session_start();
require 'database.php'; // استدعاء ملف الاتصال بقاعدة البيانات

// استعلام لاسترجاع جميع الإدارات
$sql = "SELECT department_id, department_name, department_section, department_unit FROM departments";
$result = $conn->query($sql);

echo '<table class="table">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">الرقم</th>';
echo '<th scope="col">اسم الإدارة</th>';
echo '<th scope="col">القسم</th>';
echo '<th scope="col">الوحدة</th>';
echo '<th scope="col">الإجراءات</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if ($result->num_rows > 0) {
    // عرض جميع الإدارات
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<th scope='row' class='align-middle'>" . $row['department_id'] . "</th>";
        echo "<td class='align-middle'>" . htmlspecialchars($row['department_name']) . "</td>";
        echo "<td class='align-middle'>" . htmlspecialchars($row['department_section']) . "</td>";
        echo "<td class='align-middle'>" . htmlspecialchars($row['department_unit']) . "</td>";
        echo "<td>";

        // زر التفاصيل
        echo "<a href='details.php?id=" . $row['department_id'] . "' class='btn btn-success custom-btn-main m-2'>التفاصيل</a>";

        // زر تعديل الإدارة
        echo "<a href='edit_department.php?id=" . $row['department_id'] . "' class='btn btn-warning custom-btn-main m-2'>تعديل</a>";

        // زر حذف الإدارة
        echo "<a href='#' class='btn btn-danger custom-btn-main m-2' 
        onclick='
        Swal.fire({
            icon: `warning`, 
            title: `تنبيه`, 
            text: \"هل أنت متأكد أنك تريد حذف هذه الإدارة؟\",
            confirmButtonText: `نعم`,
            customClass: {
                confirmButton: `btn btn-primary`,
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href=\"php/delete_department.php?id=" . $row['department_id'] . "\";
            }
        });
        '>حذف</a>";

        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>لا توجد إدارات متاحة</td></tr>";
}

echo '</tbody>';
echo '</table>';

$conn->close(); // إغلاق الاتصال بقاعدة البيانات
?>
