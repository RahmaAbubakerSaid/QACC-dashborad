// إظهار dialog
const openDialogButtons = document.querySelectorAll('.openDialogCategories');
const dialogs = document.querySelectorAll('.dialog');

openDialogButtons.forEach((button) => {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        const dialogId = button.getAttribute('id');
        const dialog = document.getElementById(dialogId);
        dialog.style.display = 'block';
    });
});

dialogs.forEach((dialog) => {
    const closeDialogButton = dialog.querySelector('.closeDialogCategories');
    
    closeDialogButton.addEventListener('click', function () {
        dialog.style.display = 'none';
    });

    dialog.addEventListener('click', function (event) {
        if (event.target === dialog) {
            dialog.style.display = 'none';
        }
    });
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