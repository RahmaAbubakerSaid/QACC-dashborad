document.getElementById('save-button').addEventListener('click', () => {
    const userSelect = document.getElementById('user-select');
    const selectedUser = userSelect.options[userSelect.selectedIndex].text;

    if (selectedUser === "اختر مستخدم") {
        alert('يرجى اختيار مستخدم.');
        return;
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
});