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
function validateFormOffice(){
    var officeName = document.getElementById('officeName').value;
    
    //التحقق من اسم المكتب 
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
