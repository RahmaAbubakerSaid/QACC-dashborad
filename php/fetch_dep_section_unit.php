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
    $searchTerm = "%$search%";  // البحث باستخدام مثل
    $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);  // ربط المتغيرات للبحث

    $stmt->execute();
    $result = $stmt->get_result();

    // جمع البيانات في مصفوفة للتعامل مع rowspan
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $departmentId = $row['department_id'];
        $sectionId = $row['section_id'];

        // إنشاء مفاتيح للإدارة والقسم
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

    // عرض الجدول
    echo '<div class="table-responsive" style="max-width: 90%; margin: 20px auto;">';
    echo '<table class="table" style="border-collapse: collapse; width: 100%; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; border: 1px  #555;">';
    echo '<thead style="background-color: #f8f9fa; color: #555; text-align: center;">';
    echo '<tr>';
    echo '<th scope="col" style="padding: 15px; text-align: center;">الإدارة</th>';
    echo '<th scope="col" style="padding: 15px; text-align: center; border-right: 1px solid #ccc;">القسم</th>';
    echo '<th scope="col" style="padding: 15px; text-align: center; border-right: 1px solid #ccc;">الوحدة</th>';
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
                    echo '<td rowspan="' . $departmentRowspan . '" style="padding: 15px; text-align: center; background-color: #f8f9fa;">' . $department['name'] . '</td>';
                    $firstDepartmentRow = false;
                }

                if ($firstSectionRow) {
                    echo '<td rowspan="' . $sectionRowspan . '" style="padding: 15px; text-align: center; background-color: #f8f9fa; border-right: 1px solid #ccc;">' . $section['name'] . '</td>';
                    $firstSectionRow = false;
                }

                echo '<td style="padding: 15px; text-align: center; background-color: #f8f9fa; border-right: 1px solid #ccc;">لا يوجد</td>';
                echo '</tr>';
            } else {
                foreach ($section['units'] as $unit) {
                    echo '<tr>';
                    if ($firstDepartmentRow) {
                        echo '<td rowspan="' . $departmentRowspan . '" style="padding: 15px; text-align: center; background-color: #f8f9fa;">' . $department['name'] . '</td>';
                        $firstDepartmentRow = false;
                    }

                    if ($firstSectionRow) {
                        echo '<td rowspan="' . $sectionRowspan . '" style="padding: 15px; text-align: center; background-color: #f8f9fa; border-right: 1px solid #ccc;">' . $section['name'] . '</td>';
                        $firstSectionRow = false;
                    }

                    echo '<td style="padding: 15px; text-align: center; background-color: #f8f9fa; border-right: 1px solid #ccc;">' . $unit . '</td>';
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
    echo "خطأ في الاستعلام: " . $conn->error;
}
?>
