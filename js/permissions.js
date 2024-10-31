// تحديد الكل
document.getElementById('select-all').addEventListener('click', () => {
    const functionCheckboxes = document.querySelectorAll('.function-checkbox');
    
    functionCheckboxes.forEach(checkbox => {
        checkbox.checked = document.getElementById('select-all').checked;
    });
});

// جلب المستخدمين من قاعدة البيانات
async function fetchUsers() {
    const response = await fetch('php/fetch_users.php');
    const users = await response.json();
    const userSelect = document.getElementById('user-select');

    users.forEach(user => {
        const option = document.createElement('option');
        option.value = user.id;
        option.textContent = user.username;
        userSelect.appendChild(option);
    });
}

// جلب الصلاحيات من قاعدة البيانات وعرضها في الجدول
async function updateResultsTable() {
    const response = await fetch('php/fetch_permissions.php');
    const permissions = await response.json();
    const resultsBody = document.getElementById('results-body');
    resultsBody.innerHTML = ''; // مسح الجدول الحالي

    // إضافة البيانات إلى الجدول
    permissions.forEach(permission => {
        const userId = permission.user_id;
        const username = permission.username;
        const sections = permission.permissions;
    
        for (const section in sections) {
            // حلقة لكل إجراء في القسم
            sections[section].forEach(action => {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${username}</td>
                    <td>${section}</td>
                    <td>${action}</td>
                `;
                resultsBody.appendChild(newRow);
            });
        }
    });


/*     permissions.forEach(permission => {
        const userId = permission.user_id;
        const username = permission.username;
        const sections = permission.permissions;

        for (const section in sections) {
            const actions = sections[section].join(', ');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${username}</td>
                <td>${section}</td>
                <td>${actions || 'لا يوجد'}</td>
            `;
            resultsBody.appendChild(newRow);
        }
    }); */

    // إظهار الجدول
    document.getElementById('results-table').style.display = 'table';
}

// استدعاء دالة جلب المستخدمين وجلب الصلاحيات عند تحميل الصفحة
window.onload = async function() {
    await fetchUsers(); // جلب المستخدمين
    await updateResultsTable(); // جلب الصلاحيات وعرضها
};

// حفظ البيانات
document.getElementById('save-button').addEventListener('click', async () => {
    const userSelect = document.getElementById('user-select');
    const userId = userSelect.value; // الحصول على معرف المستخدم

    if (userId === "") {
        Swal.fire({
            icon: 'warning',
            title: 'خطأ!',
            text: 'يرجى ادخال اسم مستخدم',
            confirmButtonText: 'حسنًا',
            customClass: {
                confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false,
            allowOutsideClick: false,
            backdrop: true
        });
        return false;
    }

    const allPermissions = []; // لإضافة جميع الصلاحيات

    const rows = document.querySelectorAll('tbody tr');

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

    // تحقق من وجود صلاحية واحدة على الأقل
    if (allPermissions.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'خطأ!',
            text: 'يرجى تحديد صلاحية واحدة على الأقل',
            confirmButtonText: 'حسنًا',
            customClass: {
                confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false,
            allowOutsideClick: false,
            backdrop: true
        });
        return false;
    }

    // إرسال البيانات إلى PHP
    const response = await fetch('php/save_permissions.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            user_id: userId,
            permissions: allPermissions
        })
    });

    const result = await response.json();
    if (result.status === 'success') {
        updateResultsTable(); // تحديث الجدول بعد الحفظ
        
        // إعادة تعيين checkboxes
        userSelect.selectedIndex = 0; // إفراغ اختيار المستخدم
        console.log('User selection reset');

        const functionCheckboxes = document.querySelectorAll('.function-checkbox');
        functionCheckboxes.forEach(checkbox => {
            checkbox.checked = false; // إعادة تعيين checkbox إلى غير محددة
            console.log('Checkbox reset');
        });
        document.getElementById('select-all').checked = false; // إعادة تعيين checkbox "تحديد الكل"
        console.log('Select all checkbox reset');
    }
});