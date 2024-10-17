// إظهار dialog
const openDialogButtons = document.querySelectorAll('.openDialogForms');
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
    const closeDialogButton = dialog.querySelector('.closeDialogForms');
    
    closeDialogButton.addEventListener('click', function () {
        dialog.style.display = 'none';
    });

    dialog.addEventListener('click', function (event) {
        if (event.target === dialog) {
            dialog.style.display = 'none';
        }
    });
});
