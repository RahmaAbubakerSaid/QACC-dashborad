// تحديد الكل
document.getElementById('select-all').addEventListener('click', () => {
    const functionCheckboxes = document.querySelectorAll('.function-checkbox');
    
    if (document.getElementById('select-all').checked) {
        functionCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
    } else {
        functionCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
    }
});

// حفظ البيانات
document.getElementById('save-button').addEventListener('click', () => {
    const userSelect = document.getElementById('user-select');
    const selectedUser = userSelect.options[userSelect.selectedIndex].text;

    if (selectedUser === "اختر مستخدم") {
        Swal.fire({
            icon: 'warning',               // أيقونة التحذير
            title: 'خطأ!',                 // عنوان التنبيه
            text: 'يرجى ادخال اسم مستخدم',  // نص التنبيه
            confirmButtonText: 'حسنًا',     // نص زر التأكيد
            customClass: {
                confirmButton: 'btn btn-primary'  // تخصيص الزر إذا كنت تستخدم Bootstrap أو CSS
            },
            buttonsStyling: false,           // تعطيل التنسيق الافتراضي للأزرار
            allowOutsideClick: false,        // منع الإغلاق عند النقر على الخلفية
            backdrop: true                   // إضافة خلفية سوداء
        });
        return false;
    }

    const allPermissions = []; // لإضافة جميع الصلاحيات

    const rows = document.querySelectorAll('tbody tr');
    let userRow = null;

    rows.forEach(row => {
        if (row.cells[0].textContent === selectedUser) {
            userRow = row;
        }
    });

    if (userRow) {
        userRow.remove(); // إزالة السطر الحالي للمستخدم إذا كان موجودًا
    }

    rows.forEach(row => {
        const section = row.cells[0].textContent;
        const functionCheckboxes = row.querySelectorAll('.function-checkbox:checked');

        const actions = [];
        functionCheckboxes.forEach(checkbox => {
            actions.push(checkbox.parentElement.textContent.trim());
        });

        if (actions.length > 0) {
            allPermissions.push({ section: section, actions: actions });
        }
    });

    // إضافة النتائج إلى الجدول
    const resultsBody = document.getElementById('results-body');
    const newRow = document.createElement('tr');
    const permissionsHtml = allPermissions.map(p => `${p.section}: ${p.actions.join(', ') || 'لا يوجد'}`).join('<br>');
    newRow.innerHTML = `
        <td>${selectedUser}</td>
        <td>${permissionsHtml || 'لا يوجد'}</td>
    `;
    resultsBody.appendChild(newRow);

    // إظهار الجدول
    document.getElementById('results-table').style.display = 'table';

    // إفراغ جميع التحديدات
    userSelect.selectedIndex = 0; // إفراغ اختيار المستخدم
    document.querySelectorAll('.function-checkbox').forEach(checkbox => {
        checkbox.checked = false; // إفراغ الوظائف
    });

    document.getElementById('select-all').checked = false;

});