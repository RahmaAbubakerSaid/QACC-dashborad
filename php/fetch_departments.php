<?php
require 'database.php'; // الاتصال بقاعدة البيانات

$query = "SELECT department_id, department_name, manager_name FROM departments";
$result = $conn->query($query);

$counter = 1; // تعريف متغير العد

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<th scope='row'>" . $counter++ . "</th>";
        echo "<td>" . htmlspecialchars($row['department_name']) . "</td>";
        echo "<td>" . (!empty($row['manager_name']) ? htmlspecialchars($row['manager_name']) : 'غير محدد') . "</td>";
        echo "<td class='d-flex align-items-center'>
                <div class='btn-group'>


<a href='#' class='btn btn-success custom-btn' 
   onclick='openSectionsDialog(" . $row['department_id'] . ", \"" . addslashes($row['department_name']) . "\")'>الأقسام</a>

                    <a href='#' class='custom-btn-icon' onclick='editUnit(" . htmlspecialchars($row['department_id']) . ", \"" . addslashes($row['department_name']) . "\", \"" . addslashes($row['manager_name']) . "\")'>
                        <i class='fas fa-pencil-alt' style='color: #007bff;'></i>
                    </a>
                    <a href='#' class='custom-btn-icon' onclick='deleteDepartment(" . htmlspecialchars($row['department_id']) . ")'>
                        <i class='fas fa-trash-alt' style='color: #dc3545;'></i>
                    </a>
                </div>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>لا توجد إدارات متاحة</td></tr>";
}
$conn->close();
?>
