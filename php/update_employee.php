<?php
session_start();
require 'database.php'; // ملف الاتصال بقاعدة البيانات

// استلام البيانات من الطلب (مصفوفة `$_POST`)
$employee_number = $_POST['employeeNumber'];
$name = $_POST['name'];
$mother_name = $_POST['motherName'];
$date_of_birth = $_POST['dateOfBirth'];
$birth_place = $_POST['birthPlace'];
$age = $_POST['age'];
$national_id = $_POST['nationalId'];
$national_id_issuance_authority = $_POST['nationalIdIssuanceAuthority'];
$family_book_number = $_POST['familyBookNumber'];
$family_book_issuance_authority = $_POST['familyBookIssuanceAuthority'];
$passport_number = $_POST['passportNumber'];
$passport_issuance_authority = $_POST['passportIssuanceAuthority'];
$family_sheet_number = $_POST['familySheetNumber'];
$registration_number = $_POST['registrationNumber'];
$nationality = $_POST['nationality'];
$gender = $_POST['gender'];
$marital_status = $_POST['maritalStatus'];
$children_count = $_POST['childrenCount'];
$blood_type = $_POST['bloodType'];
$email = $_POST['email'];
$libyana_phone = $_POST['libyanaPhone'];
$madar_phone = $_POST['madarPhone'];
$financial_number = $_POST['financialNumber'];
$position = $_POST['position'];
$department = isset($_POST['department']) ? $_POST['department'] : ''; // تغيير هنا في حالة عدم اختيار الإدارة
$division = isset($_POST['division']) ? $_POST['division'] : ''; // تغيير هنا في حالة عدم اختيار القسم
$unit = isset($_POST['unit']) ? $_POST['unit'] : ''; // تغيير هنا في حالة عدم اختيار الوحدة
$office = isset($_POST['office']) ? $_POST['office'] : ''; // تغيير هنا في حالة عدم اختيار مكتب
$grade = $_POST['grade']; // الدرجة
$education = $_POST['education'];
$job_status = $_POST['jobStatus'];
$job_number = $_POST['jobNumber'];  // الرقم الوظيفي
$join_date = $_POST['joinDate'];
$contract_start_date = $_POST['contractStartDate'];
$contract_duration = $_POST['contractDuration'];
$guarantee_number = $_POST['guaranteeNumber'];
$current_allowance = $_POST['currentAllowance'];
$bank_name = $_POST['bankName'];
$account_number = $_POST['accountNumber'];
$monthly_salary = $_POST['monthlySalary'];
$annual_leave = $_POST['annualLeave'];
$annual_increase = $_POST['annualIncrease'];
$emergency_leave_balance = $_POST['emergencyLeaveBalance'];
$last_promotion_date = $_POST['lastPromotionDate'];
$last_allowance_date = $_POST['lastAllowanceDate'];
$notes = $_POST['notes'];
$updated_by = $_POST['updated_by']; // اسم المستخدم الذي قام بالتعديل
$updated_at = $_POST['updated_at']; // وقت التعديل


// التحقق من وجود المعامل 'id' في الطلب
if (isset($_GET['id'])) {
    $employeeId = $_GET['id'];

    // تحضير استعلام SQL لتحديث البيانات في الجدول
    $sql = "UPDATE employees SET 
        employee_number = '$employee_number', 
        name = '$name', 
        mother_name = '$mother_name', 
        date_of_birth = '$date_of_birth', 
        birth_place = '$birth_place', 
        age = '$age', 
        national_id = '$national_id', 
        national_id_issuance_authority = '$national_id_issuance_authority', 
        family_book_number = '$family_book_number', 
        family_book_issuance_authority = '$family_book_issuance_authority', 
        passport_number = '$passport_number', 
        passport_issuance_authority = '$passport_issuance_authority', 
        family_sheet_number = '$family_sheet_number', 
        registration_number = '$registration_number', 
        nationality = '$nationality', 
        gender = '$gender', 
        marital_status = '$marital_status', 
        children_count = '$children_count', 
        blood_type = '$blood_type', 
        email = '$email', 
        libyana_phone = '$libyana_phone', 
        madar_phone = '$madar_phone', 
        financial_number = '$financial_number', 
        position = '$position', 
        department = " . (empty($department) ? "NULL" : "'$department'") . ",
        division = " . (empty($division) ? "NULL" : "'$division'") . ",
        unit = " . (empty($unit) ? "NULL" : "'$unit'") . ",
        office = " . (empty($office) ? "NULL" : "'$office'") . ",
        grade = '$grade',  -- إضافة الدرجة هنا
        education = '$education', 
        job_status = '$job_status', 
        job_number = '$job_number',  -- إضافة الرقم الوظيفي هنا
        join_date = '$join_date', 
        contract_start_date = '$contract_start_date', 
        contract_duration = '$contract_duration', 
        guarantee_number = '$guarantee_number', 
        current_allowance = '$current_allowance', 
        bank_name = '$bank_name', 
        account_number = '$account_number', 
        monthly_salary = '$monthly_salary', 
        annual_leave = '$annual_leave', 
        annual_increase = '$annual_increase', 
        emergency_leave_balance = '$emergency_leave_balance', 
        last_promotion_date = '$last_promotion_date', 
        last_allowance_date = '$last_allowance_date', 
        notes = '$notes',
        updated_by = '$updated_by',
        updated_at = '$updated_at'
                
    WHERE id = '$employeeId'";

    // تنفيذ الاستعلام
    if ($conn->query($sql) === TRUE) {
        // إرسال استجابة ناجحة
        echo json_encode(["success" => true]);
    } else {
        // إرسال استجابة فاشلة مع الخطأ
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
} else {
    // إذا لم يتم إرسال 'id'
    echo json_encode(["success" => false, "message" => "Employee ID is required."]);
}

// إغلاق الاتصال
$conn->close();
?>