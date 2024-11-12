<?php
session_start();
require 'database.php'; // استدعاء ملف الاتصال بقاعدة البيانات

// استعلام لاسترجاع جميع المستخدمين
$sql = "SELECT id, username, restricted FROM users";
$result = $conn->query($sql);

echo '<table class="table">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">الرقم</th>';
echo '<th scope="col">اسم المستخدم</th>';
echo '<th scope="col">الصلاحيات</th>';
echo '<th scope="col">الاجراءات</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if ($result->num_rows > 0) {
    $counter = 1; // المتغير الذي سيتم استخدامه كعداد
    // عرض كل المستخدمين
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<th scope='row'class='align-middle'>" . $counter++ . "</th>";
        echo "<td class='align-middle'>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td><a href='#' class='btn btn-success custom-btn-main m-2' onclick='showPermissions(" . $row['id'] . ")'>التفاصيل</a></td>";
        echo "<td>";


        // زر التقييد أو إلغاء التقييد
        if ($row['restricted'] == 1) {
            echo "<a href='#' class='btn btn-danger custom-btn-main m-2' 
            onclick='
            Swal.fire({
                icon: `warning`,
                title: `تنبيه`, 
                text: \"هل أنت متأكد من إلغاء تقييد المستخدم؟\",
                confirmButtonText: `نعم`,
                customClass: {
                    confirmButton: `btn btn-primary`,
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href=\"php/restrict_user.php?id=" . $row['id'] . "&action=unrestrict\";
                }
            });
            '>إلغاء التقييد</a>";
        } else {
            echo "<a href='#' class='btn btn-success custom-btn-main m-2' 
            onclick='
            Swal.fire({
                icon: `warning`,
                title: `تنبيه`, 
                text: \"هل أنت متأكد من تقييد المستخدم؟\",
                confirmButtonText: `نعم`,
                customClass: {
                    confirmButton: `btn btn-primary`,
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href=\"php/restrict_user.php?id=" . $row['id'] . "&action=restrict\";
                }
            });
            '>تقييد</a>";
        }
        
        
        echo "<a href='#' class='btn btn-primary custom-btn-main m-0'>سجل النشاطات</a>";
        echo "<a href='#' class='btn btn-danger custom-btn-main m-2' 
        onclick='
        Swal.fire({
        icon: `warning`,               // أيقونة التحذير

        title: `تنبيه`, 
        text: \"هل أنت متأكد أنك تريد حذف هذا المستخدم؟\",
        confirmButtonText: `نعم`,
        customClass: {
            confirmButton: `btn btn-primary` ,  // تخصيص زر النعم
        },
        buttonsStyling: false     // تعطيل التنسيق الافتراضي للأزرار
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href=\"php/delete_user.php?id=" . $row['id'] . "\";
            }
        });
        '>حذف</a>";        
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>لا توجد مستخدمين متاحين</td></tr>"; 
}

echo '</tbody>';
echo '</table>';


$conn->close(); // إغلاق الاتصال بقاعدة البيانات

?>


