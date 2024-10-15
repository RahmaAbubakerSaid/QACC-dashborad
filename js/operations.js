////////////////////////////////////////////////////////////////////////////////////////////////
// الكود هنا
const openDialogButton = document.getElementById('openDialog');
const closeDialogButton = document.getElementById('closeDialog');
const dialog = document.getElementById('dialog');

openDialogButton.addEventListener('click', function () {
    dialog.style.display = 'block';
});

closeDialogButton.addEventListener('click', function () {
    dialog.style.display = 'none';
});

// إضافة إغلاق المربع الحواري بالنقر على الخلفية السوداء
dialog.addEventListener('click', function (event) {
    if (event.target === dialog) {
        dialog.style.display = 'none';
    }
});

function validateFormdepartement() {
    var departementName = document.getElementById('departementName').value;
    var selectedUser = document.getElementById('user-select').value;

    // التحقق من اسم الادارة
    if (departementName.trim() === '') {
        Swal.fire({
            icon: 'warning',               // أيقونة التحذير
            title: 'خطأ!',                 // عنوان التنبيه
            text: 'يرجى إدخال اسم الادارة',  // نص التنبيه
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

    // التحقق من اختيار مدير الإدارة
    if (selectedUser === '') {
        Swal.fire({
            icon: 'warning',               // أيقونة التحذير
            title: 'خطأ!',                 // عنوان التنبيه
            text: 'يرجى اختيار مدير الإدارة',  // نص التنبيه
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

    // إذا كانت جميع القيم صحيحة، قم بإعادة تعيين الحقول
    Swal.fire({
        icon: 'success',
        title: 'تمت الإضافة بنجاح!',
        confirmButtonText: 'حسنًا',
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false,
        allowOutsideClick: false,
        backdrop: true
    }).then(() => {
        // مسح الحقول بعد الإضافة
        document.getElementById('departementName').value = '';
        document.getElementById('user-select').selectedIndex = 0;
    });

    return true;
}


function validateFormOffice(){

    var officeName = document.getElementById('officeName').value;
    var selectedUser = document.getElementById('user-select').value;

    // التحقق من اسم المكتب
    if (officeName.trim() === '') {
        Swal.fire({
            icon: 'warning',               // أيقونة التحذير
            title: 'خطأ!',                 // عنوان التنبيه
            text: 'يرجى إدخال اسم المكتب',  // نص التنبيه
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

    // التحقق من اختيار مدير المكتب
    if (selectedUser === '') {
        Swal.fire({
            icon: 'warning',               // أيقونة التحذير
            title: 'خطأ!',                 // عنوان التنبيه
            text: 'يرجى اختيار مدير المكتب',  // نص التنبيه
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

    // إذا كانت جميع القيم صحيحة، قم بإعادة تعيين الحقول
    Swal.fire({
        icon: 'success',
        title: 'تمت الإضافة بنجاح!',
        confirmButtonText: 'حسنًا',
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false,
        allowOutsideClick: false,
        backdrop: true
    }).then(() => {
        // مسح الحقول بعد الإضافة
        document.getElementById('officeName').value = '';
        document.getElementById('user-select').selectedIndex = 0;
    });

    return true;
}
///////////////////////////////////////////////////////////////////////////////////////////////
// الكود هنا
function validateForm() {
    var username = document.getElementById('floatingText').value;
    var password = document.getElementById('floatingInput').value;

    if (username.trim() === '') {
        alert('يرجى إدخال اسم المستخدم');
        return false;
    }

    if (password.trim() === '') {
        alert('يرجى إدخال كلمة المرور');
        return false;
    }
}
// دالة لفتح نافذة الأقسام وعرض اسم الإدارة
function openDetails(departmentName) {
    document.getElementById('departmentTitle').innerText = departmentName; // وضع اسم الإدارة في الأعلى
    document.getElementById('detailsModal').style.display = 'block'; // عرض النافذة
}

function validateSectionForm() {
    var sectionName = document.getElementById('sectionName').value.trim();
    var sectionManager = document.getElementById('section-manager-select').value.trim();

    // التحقق من اسم القسم
    if (sectionName === '') {
        Swal.fire({
            icon: 'warning',
            title: 'خطأ!',
            text: 'يرجى إدخال اسم القسم',
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

    // التحقق من اختيار مدير القسم
    if (sectionManager === '') {
        Swal.fire({
            icon: 'warning',
            title: 'خطأ!',
            text: 'يرجى اختيار مدير القسم',
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

    // إذا كانت جميع القيم صحيحة
    Swal.fire({
        icon: 'success',
        title: 'تمت الإضافة بنجاح!',
        confirmButtonText: 'حسنًا',
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false,
        allowOutsideClick: false,
        backdrop: true
    }).then(() => {
        // مسح الحقول بعد الإضافة
        document.getElementById('sectionName').value = '';
        document.getElementById('sectionManagerSelect').selectedIndex = 0;
    });

    return true;
}

function closeSectionsDialog() {
    document.getElementById('sectionsDialog').style.display = 'none'; // إخفاء نافذة الأقسام
}

function openSectionsDialog(departmentName) {
    document.getElementById('departmentTitle').innerText = 'إضافة قسم - ' + departmentName; // وضع اسم الإدارة في الأعلى
    document.getElementById('sectionsDialog').style.display = 'block'; // عرض نافذة الأقسام
}


// دالة للتعديل على القسم 
function editSection(sectionName) {
    Swal.fire({
        icon: 'info',
        title: 'تعديل القسم',
        text: 'سيتم فتح نافذة تعديل القسم: ' + sectionName,
        confirmButtonText: 'حسنًا',
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false,
        allowOutsideClick: false,
        backdrop: true
    });
}
   //دالة حذف القسم
function deleteSection(sectionName) {
    Swal.fire({
        icon: 'warning',
        title: 'هل أنت متأكد؟',
        text: 'سيتم حذف القسم: ' + sectionName,
        showCancelButton: true,
        confirmButtonText: 'موافق',
        cancelButtonText: 'إلغاء',
        customClass: {
            confirmButton: 'btn btn-danger ms-2',  // إضافة مسافة إلى زر موافق
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false,
        allowOutsideClick: false,
        backdrop: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'تم الحذف بنجاح!',
                confirmButtonText: 'حسنًا',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false,
                allowOutsideClick: false,
                backdrop: true
            });
        }
    });

    
}

// فتح dialog  وعرض اسم القسم
function openUnitDialog(sectionName) {
    document.getElementById('unitDialogTitle').innerText = 'إضافة وحدة في ' + sectionName;
    document.getElementById('unitDialog').style.display = 'block'; // عرض النافذة
}

// التحقق من صحة المدخلات عند إضافة الوحدة
function validateFormUnit() {
    var unitName = document.getElementById('unitName').value;
    var selectedManager = document.getElementById('unit-manager-select').value;
   
    
   
    // التحقق من اسم الوحدة
    if (unitName.trim() === '') {
        Swal.fire({
            icon: 'warning',
            title: 'خطأ!',
            text: 'يرجى إدخال اسم الوحدة',
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

    // التحقق من اختيار مدير الوحدة
    if (selectedManager === '') {
        Swal.fire({
            icon: 'warning',
            title: 'خطأ!',
            text: 'يرجى اختيار مدير الوحدة',
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

    // في حالة نجاح التحقق
    Swal.fire({
        icon: 'success',
        title: 'تمت الإضافة بنجاح!',
        confirmButtonText: 'حسنًا',
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false,
        allowOutsideClick: false,
        backdrop: true
    }).then(() => {
        // مسح الحقول بعد الإضافة
        document.getElementById('unitName').value = '';
        document.getElementById('unit-manager-select').selectedIndex = 0;
    });

    return true;
}


// دالة للتعديل على الوحدة
function editUnit(unitName) {
    Swal.fire({
        icon: 'info',
        title: 'تعديل الوحدة',
        text: 'سيتم فتح نافذة تعديل الوحدة: ' + unitName,
        confirmButtonText: 'حسنًا',
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false,
        allowOutsideClick: false,
        backdrop: true
    });
}

// دالة لحذف الوحدة
function deleteUnit(unitName) {
    Swal.fire({
        icon: 'warning',
        title: 'هل أنت متأكد؟',
        text: 'سيتم حذف الوحدة: ' + unitName,
        showCancelButton: true,
        confirmButtonText: 'موافق',
        cancelButtonText: 'إلغاء',
        customClass: {
            confirmButton: 'btn btn-danger ms-2',  // إضافة مسافة إلى زر موافق
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false,
        allowOutsideClick: false,
        backdrop: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'تم الحذف بنجاح!',
                confirmButtonText: 'حسنًا',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false,
                allowOutsideClick: false,
                backdrop: true
            });
        }
    });
}


function closeUnitDialog() {
    const unitDialog = document.getElementById('unitDialog');
    if (unitDialog) {
        unitDialog.style.display = 'none'; // إخفاء النافذة
    }
}


// دالة للتعديل على مكتب 
function editOffice(officeName) {
    Swal.fire({
        icon: 'info',
        title: 'تعديل المكتب',
        text: 'سيتم فتح نافذة تعديل المكتب: ' + officeName,
        confirmButtonText: 'حسنًا',
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false,
        allowOutsideClick: false,
        backdrop: true
    });
}
   //دالة حذف مكتب
function deleteOffice(officeName) {
    Swal.fire({
        icon: 'warning',
        title: 'هل أنت متأكد؟',
        text: 'سيتم حذف مكتب: ' + officeName,
        showCancelButton: true,
        confirmButtonText: 'موافق',
        cancelButtonText: 'إلغاء',
        customClass: {
            confirmButton: 'btn btn-danger ms-2',  // إضافة مسافة إلى زر موافق
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false,
        allowOutsideClick: false,
        backdrop: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'تم الحذف بنجاح!',
                confirmButtonText: 'حسنًا',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false,
                allowOutsideClick: false,
                backdrop: true
            });
        }
    });

    
}


function showDetails() {
    // إظهار الـ dialog فقط بدون تمرير قائمة الموظفين
    document.getElementById('detailsDialog').style.display = 'block';
}

function closeDetails() {
    document.getElementById('detailsDialog').style.display = 'none';
}

