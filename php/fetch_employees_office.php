<?php
require 'database.php';

if (isset($_POST['office_id'])) {
    $officeId = $_POST['office_id'];

    // استعلام لجلب بيانات الموظفين مع اسم المكتب من جدول المكاتب
    $query = "
        SELECT e.id, e.name, e.position, o.office_name 
        FROM employees e 
        JOIN offices o ON e.office = o.office_id 
        WHERE e.office = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $officeId);
    $stmt->execute();
    $result = $stmt->get_result();

    $output = '';
    $counter = 1; // رقم تسلسلي يبدأ من 1
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $output .= "
                <tr>
                    <td>{$counter}</td> <!-- الرقم التسلسلي -->
                    <td>{$row['name']}</td>
                    <td>{$row['position']}</td>
                    <td>{$row['office_name']}</td> <!-- اسم المكتب -->
                </tr>
            ";
            $counter++; // زيادة الرقم التسلسلي بمقدار 1
        }
    } else {
        $output = "<tr><td colspan='4' class='text-danger'>لا توجد بيانات متاحة</td></tr>";
    }
    echo $output;
}
?>
