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
