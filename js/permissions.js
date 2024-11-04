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
    
    //تنظيم الصلاحيات الخاصة بكل مستخدم
    //Key - value
    //value عبارة عن مصفوفة
    //
    const userSectionsMap = new Map(); // خريطة لتخزين الأقسام لكل مستخدم

    // تنظيم البيانات في خريطة
    permissions.forEach(permission => {
        //يتم استخراج اسم المستخدم من كل عنصر
        const username = permission.username;
        //يتم استخراج الاقسام المرتبطة بكل مستخدم
        const sections = permission.permissions;

        /*
        const permissions = [
            { username: "محمد", permissions: { "القسم الأول": ["قراءة", "تعديل"], "القسم الثاني": ["حذف"] } },
            { username: "أميرة", permissions: { "القسم الأول": ["قراءة"], "القسم الثاني": ["تعديل", "حذف"] } }
        ];
        */

        //يتم التحقق اذا كان اسم المستخدم موجود في الخريطة
        //اذا لم يكن موجود يتم اضافته في الخريطة كمفتاح في الخريطة
        if (!userSectionsMap.has(username)) {
            userSectionsMap.set(username, new Map()); // إضافة المستخدم إلى الخريطة إذا لم يكن موجودًا
        }

        /*
        userSectionsMap
            ├── "مستخدم1"
            │   ├── "القسم الأول": ["قراءة", "تعديل"]
            │   └── "القسم الثاني": ["حذف"]
            └── "مستخدم2"
                ├── "القسم الأول": ["قراءة"]
                └── "القسم الثاني": ["تعديل", "حذف"]
        */

        //userSectionsMap (الذي يحتوي على بيانات جميع المستخدمين وصلاحياتهم)
        //يتم الحصول على القيمة المرتبطة بمفتاح المستخدم من  userSectionsMap
        const userActionsMap = userSectionsMap.get(username);
        //يتم استخراج الصلاحيات المتعلقة بالقسم الحالي.
        for (const section in sections) {
            const actions = sections[section];

            if (!userActionsMap.has(section)) {
                userActionsMap.set(section, []); // إضافة القسم إذا لم يكن موجودًا
            }
            userActionsMap.get(section).push(...actions); // إضافة الوظائف إلى القائمة
        }
    });

    // إضافة البيانات إلى الجدول
    //يتم بعد ذلك إنشاء الصفوف في الجدول بناءً على البيانات المنظمة. كل مستخدم يظهر في صف واحد مع أقسامه وصلاحياته.
    userSectionsMap.forEach((sectionsMap, username) => {
        const sectionEntries = Array.from(sectionsMap.entries()); // تحويل الخريطة إلى مصفوفة

        sectionEntries.forEach(([section, actions], index) => {
            const newRow = document.createElement('tr');
            const actionsFormatted = actions.join('<br>'); // فصل الإجراءات في سطور جديدة

            if (index === 0) {
                newRow.innerHTML = `
                    <td rowspan="${sectionEntries.length}">${username}</td>
                    <td>${section}</td>
                    <td>${actionsFormatted}</td>
                `;
            } else {
                newRow.innerHTML = `
                    <td>${section}</td>
                    <td>${actionsFormatted}</td>
                `;
            }
            resultsBody.appendChild(newRow);
        });
    });

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