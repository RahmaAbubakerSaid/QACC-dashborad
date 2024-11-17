<?php
require 'database.php';

$departmentId = $_GET['department_id'];

$query = "SELECT section_id, section_name, manager_name FROM sections WHERE department_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $departmentId);
$stmt->execute();
$result = $stmt->get_result();

$counter = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<th scope='row'>" . $counter++ . "</th>";
        echo "<td>" . htmlspecialchars($row['section_name']) . "</td>";
        echo "<td class='d-flex align-items-center'>
                <div class='btn-group'>
                    <a href='#' class='btn btn-success custom-btn' onclick='openUnitDialog(\"" . addslashes($row['section_name']) . "\")'>الوحدات</a>
                    <a href='#' class='custom-btn-icon' onclick='editSection(" . $row['section_id'] . ", \"" . addslashes($row['section_name']) . "\")'>
                        <i class='fas fa-pencil-alt' style='color: #007bff;'></i>
                    </a>
                    <a href='#' class='custom-btn-icon' onclick='deleteSection(" . $row['section_id'] . ")'>
                        <i class='fas fa-trash-alt' style='color: #dc3545;'></i>
                    </a>
                </div>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>لا توجد أقسام متاحة</td></tr>";
}

$stmt->close();
$conn->close();
?>
