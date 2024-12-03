$(document).ready(function () {
    // تحميل الإدارات عند تحميل الصفحة
    loadDepartments();

    // عند اختيار إدارة
    $('#departmentSelect').change(function () {
        const departmentId = $(this).val();
        if (departmentId) {
            loadSections(departmentId);
        } else {
            $('#sectionSelect').html('<option value="">اختر الإدارة أولاً</option>').prop('disabled', true);
            $('#unitSelect').html('<option value="">اختر القسم أولاً</option>').prop('disabled', true);
        }
    });

    // عند اختيار قسم
    $('#sectionSelect').change(function () {
        const sectionId = $(this).val();
        if (sectionId) {
            loadUnits(sectionId);
        } else {
            $('#unitSelect').html('<option value="">اختر القسم أولاً</option>').prop('disabled', true);
        }
    });

    // دالة لتحميل الإدارات
    function loadDepartments() {
        $.get('php/load_departments.php', function (data) {
            $('#departmentSelect').html(data);
        });
    }

    // دالة لتحميل الأقسام
    function loadSections(departmentId) {
        $.get('php/load_sections.php', { department_id: departmentId }, function (data) {
            $('#sectionSelect').html(data).prop('disabled', false);
        });
    }

    // دالة لتحميل الوحدات
    function loadUnits(sectionId) {
        $.get('php/load_units.php', { section_id: sectionId }, function (data) {
            $('#unitSelect').html(data).prop('disabled', false);
        });
    }
});
