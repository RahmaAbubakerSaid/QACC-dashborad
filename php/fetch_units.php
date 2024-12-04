<?php
// ربط قاعدة البيانات
include 'database.php';

// التحقق من أن الـ section_id تم إرساله
if (isset($_GET['section_id'])) {
    $sectionId = $_GET['section_id'];

    // استعلام لجلب الوحدات بناءً على القسم
    $sql = "SELECT * FROM units WHERE section_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $sectionId);
        $stmt->execute();
        $result = $stmt->get_result();

        // عرض الوحدات في الجدول
        if ($result->num_rows > 0) {
            $index = 1; // متغير لحساب الرقم
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<th scope='row'>{$index}</th>";
                echo "<td>{$row['unit_name']}</td>";
                echo "<td>" . (!empty($row['manager_name']) ? $row['manager_name'] : 'غير محدد') . "</td>";
                echo "<td class='d-flex align-items-center'>
                        <div class='btn-group'>
                         <a href='#' class='custom-btn-icon' onclick='editUnitFun(\"" . $row['unit_id'] . "\", \"" . htmlspecialchars($row['unit_name']) . "\", \"" . htmlspecialchars($row['manager_name']) . "\")'>
                                <i class='fas fa-pencil-alt' style='color: #007bff;'></i>
                            </a>
                             <a href='#' class='custom-btn-icon' onclick='deleteUnit(\"" . $row['unit_id'] . "\", \"" . $sectionId . "\")'>
                                <i class='fas fa-trash-alt' style='color: #dc3545;'></i>
                            </a>
                            
                        </div>
                      </td>";
                echo "</tr>";
                $index++;
            }
        } else {
            echo "<tr><td colspan='3'>لا توجد وحدات لهذا القسم.</td></tr>";
        }
        $stmt->close();
    } else {
        echo "<tr><td colspan='3'>حدث خطأ أثناء جلب البيانات.</td></tr>";
    }
}
?>
