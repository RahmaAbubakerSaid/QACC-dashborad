// إظهار dialog
const openDialogButton = document.getElementById('openDialogCategories');
const closeDialogButton = document.getElementById('closeDialogCategories');
const dialog = document.getElementById('dialogCategories');

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



// كود تعديل الكمية
function editQuantity(button) {
    var span = button.parentElement.previousElementSibling.querySelector('span');
    var input = button.parentElement.previousElementSibling.querySelector('input');
    // اخفاء الكمية
    span.style.display = 'none';
    // إظهار حقل لتمكين تحرير الكمية
    input.style.display = 'inline-block';
    // قيمة الحقل تعكس ماهو موجود
    input.value = span.textContent;


    button.style.display = 'none';
    button.nextElementSibling.style.display = 'inline-block';
}

function saveQuantity(button) {
    var span = button.parentElement.previousElementSibling.querySelector('span');
    var input = button.parentElement.previousElementSibling.querySelector('input');
    // اظهار الكمية
    span.style.display = 'inline-block';
    // القيمة تعكس ماتم ادخالها في الحقل
    span.textContent = input.value;
    // اخفاء الحقل
    input.style.display = 'none';

    button.style.display = 'none';
    button.previousElementSibling.style.display = 'inline-block';
}