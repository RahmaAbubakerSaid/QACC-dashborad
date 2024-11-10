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
$department = $_POST['department'];
$division = $_POST['division'];
$education = $_POST['education'];
$job_status = $_POST['jobStatus'];
$join_date = $_POST['joinDate'];
$contract_start_date = $_POST['contractStartDate'];
$contract_duration = $_POST['contractDuration'];
$guarantee_number = $_POST['guaranteeNumber'];
$current_allowance = $_POST['currentAllowance'];
$bank_name = $_POST['bankName'];
$account_number = $_POST['accountNumber'];
$monthly_salary = $_POST['monthlySalary'];
$annual_leave = $_POST['annualLeave'];
$grade = $_POST['grade'];
$annual_increase = $_POST['annualIncrease'];
$emergency_leave_balance = $_POST['emergencyLeaveBalance'];
$job_number = $_POST['jobNumber'];
$last_promotion_date = $_POST['lastPromotionDate'];
$last_allowance_date = $_POST['lastAllowanceDate'];
$notes = $_POST['notes'];
$created_by = $_POST['created_by'];

// تحضير استعلام SQL لإدخال البيانات في الجدول
$sql = "INSERT INTO employees (
    employee_number, name, mother_name, date_of_birth, birth_place, age, national_id,
    national_id_issuance_authority, family_book_number, family_book_issuance_authority, passport_number,
    passport_issuance_authority, family_sheet_number, registration_number, nationality, gender, marital_status,
    children_count, blood_type, email, libyana_phone, madar_phone, financial_number, position, department,
    division, education, job_status, join_date, contract_start_date, contract_duration, guarantee_number,
    current_allowance, bank_name, account_number, monthly_salary, annual_leave, grade, annual_increase,
    emergency_leave_balance,job_number, last_promotion_date, last_allowance_date, notes,created_by
) VALUES (
    '$employee_number', '$name', '$mother_name', '$date_of_birth', '$birth_place', '$age', '$national_id',
    '$national_id_issuance_authority', '$family_book_number', '$family_book_issuance_authority', '$passport_number',
    '$passport_issuance_authority', '$family_sheet_number', '$registration_number', '$nationality', '$gender', '$marital_status',
    '$children_count', '$blood_type', '$email', '$libyana_phone', '$madar_phone', '$financial_number', '$position', '$department',
    '$division', '$education', '$job_status', '$join_date', '$contract_start_date', '$contract_duration', '$guarantee_number',
    '$current_allowance', '$bank_name', '$account_number', '$monthly_salary', '$annual_leave', '$grade', '$annual_increase',
    '$emergency_leave_balance','$job_number', '$last_promotion_date', '$last_allowance_date', '$notes','$created_by'
)";

// تنفيذ الاستعلام
if ($conn->query($sql) === TRUE) {
    // إرسال استجابة ناجحة
    echo json_encode(["success" => true]);
} else {
    // إرسال استجابة فاشلة مع الخطأ
    echo json_encode(["success" => false, "error" => $conn->error]);
}

// إغلاق الاتصال
$conn->close();
?>
