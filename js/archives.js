          // وظيفة إرسال الرسائل
          //تحديد الزر المحدد الذي عند النقر عليه يتم تنفيذ العملية
    document.getElementById('sendButton').addEventListener('click', function() {
        //الحصول على العنصر وتخزينة في متغير
        const messageInput = document.getElementById('messageInput');
        //ازالة الفراغات الزايدة
        const messageText = messageInput.value.trim();
        //يتم اختيار جميع الصناديق المحددة التي تحمل نوع checkbox داخل employee-box
        //يتم وضعهم داخل مصفوفة يتم استخراج النصوص من الصناديق المحددة
        const selectedEmployees = Array.from(document.querySelectorAll('.employee-box input[type="checkbox"]:checked')).map(cb => cb.parentElement.querySelector('p').textContent);
  
        //يتحقق مما اذا كانت المصفوفة فارغة بمعنى لايوجد بها موظفين
        if (!selectedEmployees.length) {
            Swal.fire({
                icon: 'warning',               // أيقونة التحذير
                title: 'خطأ!',                 // عنوان التنبيه
                text: ' يرجى اختيار موظف واحد على الأقل لإرسال الرسالة.',  // نص التنبيه
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
          //يتحقق مما اذا كان حقل الرسائل  فارغ

        if (!messageText) {
            Swal.fire({
                icon: 'warning',               // أيقونة التحذير
                title: 'خطأ!',                 // عنوان التنبيه
                text: 'يرجى كتابة رسالة قبل الإرسال.',  // نص التنبيه
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
       
        selectedEmployees.forEach(employee => {
          addMessage(messageText, null, employee);
        });
        messageInput.value = ''; // مسح حقل الإدخال بعد الإرسال
      });

        // وظيفة لإضافة الرسالة إلى الدردشة

        // إضافة نص الرسالة
        //إضافة رابط للملف في حال وجوده
        //إضافة تفاصيل المستلم
        //إضافة تاريخ الرسالة
        //إضافة زر الحذف
        //إضافة العناصر إلى الصفحة
// تعديل وظيفة addMessage لإضافة رابط تحميل الملف أو المجلد
function addMessage(text, file = null, recipient = null, directoryName = null, directoryUrl = null) {
  const messageWrapper = document.createElement('div');
  messageWrapper.className = 'message-wrapper';
  const messageBox = document.createElement('div');
  messageBox.className = 'message-box';

  // إضافة نص الرسالة
  messageBox.innerHTML = `<p>${text}</p>`;

    // إذا كان هناك ملف، تحقق مما إذا كان صورة
    if (file) {
        const imgTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp'];
        if (imgTypes.includes(file.type)) {
            // تغيير النص إلى "تم إرسال صورة:"
            messageBox.innerHTML = `<p>تم إرسال صورة</p>`;

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.width = '100px'; // حجم الصورة
            img.style.cursor = 'pointer'; // تغيير شكل المؤشر عند المرور عليها
            img.onclick = function() {
                const link = document.createElement('a');
                link.href = img.src;
                link.download = file.name; // حفظ الصورة
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            };
            messageBox.appendChild(img);
        } else {
          const fileLink = document.createElement('a');
          fileLink.href = URL.createObjectURL(file);
          fileLink.download = file.name;
          fileLink.textContent = `تحميل الملف: ${file.name}`;
          fileLink.style.display = 'block';
          fileLink.style.marginTop = '5px';
          messageBox.appendChild(fileLink);
      }
  }

  // إضافة رابط تحميل المجلد إذا كان موجوداً
  if (directoryUrl) {
      const dirLink = document.createElement('a');
      dirLink.href = directoryUrl;
      dirLink.download = directoryName;
      dirLink.textContent = `تحميل المجلد: ${directoryName}`;
      dirLink.style.display = 'block';
      dirLink.style.marginTop = '5px';
      messageBox.appendChild(dirLink);
  }

  const recipientTag = document.createElement('p');
  recipientTag.textContent = `إلى: ${recipient}`;
  recipientTag.style.fontWeight = 'bold';
  messageBox.appendChild(recipientTag);

  const messageDate = document.createElement('p');
  messageDate.className = 'message-date';
  const now = new Date();
  messageDate.textContent = now.toLocaleString('ar-EG', { hour: 'numeric', minute: 'numeric', day: 'numeric', month: 'numeric', year: 'numeric' });
  messageBox.appendChild(messageDate);

  const deleteButton = document.createElement('span');
  deleteButton.className = 'delete-message';
  deleteButton.innerHTML = `<i class="fas fa-solid fa-trash"></i>`;
  deleteButton.onclick = function() { deleteMessage(messageWrapper); };

  messageWrapper.appendChild(messageBox);
  messageWrapper.appendChild(deleteButton);
  
  const chatContainer = document.getElementById('chatContainer');
  chatContainer.prepend(messageWrapper); // إضافة الرسالة إلى بداية قائمة الرسائل
}
      
    // وظيفة لفتح حقل إدخال الملفات
    document.getElementById('attachFile').addEventListener('click', function() {
        document.getElementById('fileInput').click();
      });
  
      // وظيفة لإرسال الملفات
      document.getElementById('fileInput').addEventListener('change', function(event) {
        const files = event.target.files;
        const selectedEmployees = Array.from(document.querySelectorAll('.employee-box input[type="checkbox"]:checked')).map(cb => cb.parentElement.querySelector('p').textContent);
    
        if (files.length > 0 && selectedEmployees.length > 0) {
            for (let i = 0; i < files.length; i++) {
                selectedEmployees.forEach(employee => {
                    addMessage(`تم إرسال ملف:`, files[i], employee);
                });
            }
        }
    });
  
// وظيفة لسحب وإفلات الملفات
const dropArea = document.getElementById('dropArea');

dropArea.addEventListener('dragover', (event) => {
    event.preventDefault();
    dropArea.style.borderColor = '#aaa';
});

dropArea.addEventListener('dragleave', () => {
    dropArea.style.borderColor = '#ddd';
});

dropArea.addEventListener('drop', (event) => {
    event.preventDefault();
    dropArea.style.borderColor = '#ddd';

    const items = event.dataTransfer.items;
    const selectedEmployees = Array.from(document.querySelectorAll('.employee-box input[type="checkbox"]:checked')).map(cb => cb.parentElement.querySelector('p').textContent);

    if (selectedEmployees.length > 0) {
        for (let i = 0; i < items.length; i++) {
            const item = items[i].webkitGetAsEntry();
            if (item.isFile) {
                item.file(file => {
                    selectedEmployees.forEach(employee => {
                        addMessage(`تم إرسال ملف:`, file, employee);
                    });
                });
            } else if (item.isDirectory) {
                handleDirectory(item, selectedEmployees);
            }
        }
    }
});

// معالجة المجلدات
function handleDirectory(directory, selectedEmployees) {
  const zip = new JSZip();
  const folder = zip.folder(directory.name);
  const reader = directory.createReader();

  reader.readEntries((entries) => {
      const promises = entries.map(entry => {
          return new Promise((resolve) => {
              if (entry.isFile) {
                  entry.file(file => {
                      folder.file(file.name, file);
                      resolve();
                  });
              } else if (entry.isDirectory) {
                  handleDirectory(entry, selectedEmployees);
                  resolve();
              }
          });
      });

      Promise.all(promises).then(() => {
          zip.generateAsync({ type: "blob" }).then(content => {
              const blobUrl = URL.createObjectURL(content);
              selectedEmployees.forEach(employee => {
                  const messageText = `تم إرسال مجلد:`;
                  addMessage(messageText, null, employee, directory.name, blobUrl);
              });
          });
      });
  });
}

      
      // وظيفة لحذف الرسالة
      function deleteMessage(messageWrapper) {
        messageWrapper.remove();
      }
    


function filterMessages() {
    const input = document.getElementById('messageSearchInput');
    const filter = input.value.toLowerCase();
    const chatContainer = document.getElementById('chatContainer');
    const messages = chatContainer.getElementsByClassName('message-wrapper');

    for (let i = 0; i < messages.length; i++) {
        const messageBox = messages[i].getElementsByClassName('message-box')[0];
        const recipientTag = messageBox.getElementsByTagName('p')[1]; // الفرضية أن الاسم في الفقرة الثانية
        
        // تحقق مما إذا كان الاسم موجودًا في النص
        if (recipientTag && recipientTag.textContent.toLowerCase().includes(filter)) {
            messages[i].style.display = ''; // إظهار الرسالة
        } else {
            messages[i].style.display = 'none'; // إخفاء الرسالة
        }
    }
}
    