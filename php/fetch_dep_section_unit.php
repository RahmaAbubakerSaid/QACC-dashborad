<?php
require 'database.php'; // افترض أن ملف الاتصال يستخدم مكتبة mysqli

// الحصول على قيمة البحث من الطلب (إذا كانت موجودة)
$search = isset($_GET['search']) ? $_GET['search'] : '';

// إنشاء استعلام SQL لجلب البيانات
$query = "
    SELECT 
        d.department_id, 
        d.department_name, 
        s.section_id, 
        s.section_name, 
        u.unit_id, 
        u.unit_name
    FROM 
        departments d
    LEFT JOIN 
        sections s ON d.department_id = s.department_id
    LEFT JOIN 
        units u ON s.section_id = u.section_id
    WHERE 
        d.department_name LIKE ? OR
        s.section_name LIKE ? OR
        u.unit_name LIKE ?
    ORDER BY 
        d.department_id, s.section_id, u.unit_id
";

// تنفيذ الاستعلام
if ($stmt = $conn->prepare($query)) {
    $searchTerm = "%$search%";
    $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);

    $stmt->execute();
    $result = $stmt->get_result();

    // جمع البيانات
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $departmentId = $row['department_id'];
        $sectionId = $row['section_id'];

        if (!isset($data[$departmentId])) {
            $data[$departmentId] = [
                'name' => $row['department_name'],
                'sections' => []
            ];
        }
        if (!isset($data[$departmentId]['sections'][$sectionId])) {
            $data[$departmentId]['sections'][$sectionId] = [
                'name' => $row['section_name'],
                'units' => []
            ];
        }
        if ($row['unit_name']) {
            $data[$departmentId]['sections'][$sectionId]['units'][] = $row['unit_name'];
        }
    }

    // إنشاء الجدول بنفس التنسيق
    echo '<div class="table-responsive">';
    echo '<table class="table text-start align-middle table-bordered table-hover mb-0">';
    echo '<thead>';
    echo '<tr class="text-dark">';
    echo '<th scope="col">الإدارة</th>';
    echo '<th scope="col">الأقسام</th>';
    echo '<th scope="col">الوحدات</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($data as $departmentId => $department) {
        $departmentRowspan = 0;
        foreach ($department['sections'] as $section) {
            $departmentRowspan += max(1, count($section['units']));
        }

        $firstDepartmentRow = true;
        foreach ($department['sections'] as $sectionId => $section) {
            $sectionRowspan = max(1, count($section['units']));
            $firstSectionRow = true;

            if (empty($section['units'])) {
                echo '<tr>';
                if ($firstDepartmentRow) {
                    echo '<td rowspan="' . $departmentRowspan . '">' . $department['name'] . '</td>';
                    $firstDepartmentRow = false;
                }

                if ($firstSectionRow) {
                    echo '<td rowspan="' . $sectionRowspan . '">' . $section['name'] . '</td>';
                    $firstSectionRow = false;
                }

                echo '<td>لا يوجد</td>';
                echo '</tr>';
            } else {
                foreach ($section['units'] as $unit) {
                    echo '<tr>';
                    if ($firstDepartmentRow) {
                        echo '<td rowspan="' . $departmentRowspan . '">' . $department['name'] . '</td>';
                        $firstDepartmentRow = false;
                    }

                    if ($firstSectionRow) {
                        echo '<td rowspan="' . $sectionRowspan . '">' . $section['name'] . '</td>';
                        $firstSectionRow = false;
                    }

                    echo '<td>' . $unit . '</td>';
                    echo '</tr>';
                }
            }
        }
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';

    $stmt->close();
} else {
    echo "<p>خطأ في الاستعلام: " . $conn->error . "</p>";
}
?>
