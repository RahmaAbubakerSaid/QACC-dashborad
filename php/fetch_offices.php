<?php
require 'database.php'; // الاتصال بقاعدة البيانات

$query = "SELECT office_id, office_name, manager_name FROM offices";
$result = $conn->query($query);

$counter = 1; // تعريف متغير العد

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<th scope='row'>" . $counter++ . "</th>";
        echo "<td>" . htmlspecialchars($row['office_name']) . "</td>";
        echo "<td>" . (!empty($row['manager_name']) ? htmlspecialchars($row['manager_name']) : 'غير محدد') . "</td>";
        echo "<td class='d-flex align-items-center'>
                <div class='btn-group'>
                    <a href='#' class='custom-btn-icon' onclick='editofficeFun(" . htmlspecialchars($row['office_id']) . ", \"" . addslashes($row['office_name']) . "\", \"" . addslashes($row['manager_name']) . "\")'>
                        <i class='fas fa-pencil-alt' style='color: #007bff;'></i>
                    </a>

                     <a href='#' class='custom-btn-icon' onclick='deleteOffice(" . htmlspecialchars($row['office_id']) . ")'>
                        <i class='fas fa-trash-alt' style='color: #dc3545;'></i>
                    </a>
                </div>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>لا توجد مكاتب حالياً.</td></tr>";
}
$conn->close();
?>
