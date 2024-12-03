<?php
require 'database.php'; // الاتصال بقاعدة البيانات

if (isset($_GET['department_id']) && is_numeric($_GET['department_id'])) {
    $department_id = intval($_GET['department_id']);

    $query = "SELECT section_id, section_name, manager_name FROM sections WHERE department_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $department_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $counter = 1; // عداد الصفوف
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<th scope='row'>" . $counter++ . "</th>";
                echo "<td>" . htmlspecialchars($row['section_name']) . "</td>";
                echo "<td>" . (!empty($row['manager_name']) ? htmlspecialchars($row['manager_name']) : "غير محدد") . "</td>";
                echo "<td class='d-flex align-items-center'>
                        <div class='btn-group'>
                                                    
                     <a href='#' class='btn btn-success custom-btn' 
                        onclick='openUnitDialog(" . $row['section_id'] . ", \"" . addslashes($row['section_name']) . "\")'>
                        الوحدات
                        </a>
                          <a href='#' class='custom-btn-icon' onclick='editSection(\"" . $row['section_id'] . "\", \"" . htmlspecialchars($row['section_name']) . "\", \"" . htmlspecialchars($row['manager_name']) . "\")'>
                                <i class='fas fa-pencil-alt' style='color: #007bff;'></i>
                            </a>
                            <a href='#' class='custom-btn-icon' onclick='deleteSection(\"" . $row['section_id'] . "\", \"" . $department_id . "\")'>
                                <i class='fas fa-trash-alt' style='color: #dc3545;'></i>
                            </a>
                        </div>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='text-center'>لا توجد أقسام</td></tr>";
        }
    } else {
        echo "<tr><td colspan='4' class='text-center'>حدث خطأ أثناء جلب الأقسام</td></tr>";
    }
    $conn->close();
} else {
    echo "<tr><td colspan='4' class='text-center'>المعرفة غير صحيحة</td></tr>";
}

 // إغلاق الاتصال بقاعدة البيانات
?>
