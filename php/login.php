<?php
// لحفظ معلومات المستخدم أثناء زيارته للصفحة
session_start();
require 'database.php'; // ملف الاتصال بقاعدة البيانات

// التحقق من إرسال النموذج
//هذا المقطع يقوم بفحص إذا كان النموذج قد تم إرساله بواسطة POST 
//ويستخرج بيانات المدخلات (اسم المستخدم وكلمة المرور) بطريقة تأمينية ويحذف الفراغات الزائدة من البيانات المدخلة.
//وإذا لم تكن معرفة، يتم تعيين قيمة فارغة للمتغير
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استخراج بيانات المدخلات
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // التحقق من وجود بيانات المدخلات
    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'يرجى إدخال اسم المستخدم وكلمة المرور.']);
        exit();
    } else {
        //استعلام لاستخراج كلمة المرور من جدول المستخدمين
        //حيث يكون اسم المستخدم (username) مساوياً للقيمة التي تم تمريرها ($username). يتم تخزين هذا الاستعلام المعد مسبقًا في المتغير $stmt.
        // استخدام prepared statements لمنع هجمات SQL injection
        // استعلام لاستخراج كلمة المرور وحالة الحساب من جدول المستخدمين
        $stmt = $conn->prepare("SELECT password, restricted FROM users WHERE username = ?");
        //يتحقق من نجاح عملية الاستعلام
        if ($stmt) {
            //يربط قيمة المدخلات بالاستعلام.
            $stmt->bind_param("s", $username);
            //تنفيذ
            $stmt->execute();
            //تخزين
            $stmt->store_result();
            
            // إذا كان اسم المستخدم موجوداً
            //يتحقق من وجود سجلات تطابق اسم المستخدم
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($stored_password, $restricted); // الحصول على كلمة المرور وحالة الحساب
                $stmt->fetch();
                
            // التحقق من حالة الحساب
            if ($restricted == 1) {
            echo json_encode(['success' => false, 'message' => 'لن تتمكن من تسجيل الدخول لأن حسابك تم تقيده.']);
            exit();
            }
                


                // التحقق من كلمة المرور بدون تشفير (مقارنة مباشرة)
                if (password_verify($password, $stored_password)) { // مقارنة مباشرة
                    // تسجيل الدخول ناجح
                    $_SESSION['username'] = $username;

                    // استعلام لجلب الصلاحيات من قاعدة البيانات
                    $stmt = $conn->prepare("SELECT section, action FROM permissions WHERE user_id = (SELECT id FROM users WHERE username = ?)");
                    if ($stmt) {
                        $stmt->bind_param("s", $username); // ربط اسم المستخدم
                        $stmt->execute(); // تنفيذ الاستعلام
                        $result = $stmt->get_result(); // الحصول على النتائج

                        $permissions = []; // مصفوفة لتخزين الصلاحيات
                        while ($row = $result->fetch_assoc()) {
                            // تخزين الإجراءات حسب القسم
                            $permissions[$row['section']][] = $row['action'];
                        }

                        // تخزين الصلاحيات في الجلسة
                        $_SESSION['permissions'] = $permissions; 
                    } else {
                        // التعامل مع الأخطاء في حال فشل الاستعلام
                        echo "Error: " . $conn->error;
                    }












                    echo json_encode(['success' => true]);
                    exit();
                } else {
                    echo json_encode(['success' => false, 'message' => 'كلمة مرور خاطئة.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'اسم المستخدم غير موجود.']);
            }
            
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ في الاتصال بقاعدة البيانات.']);
        }
    }
}

$conn->close();
?>