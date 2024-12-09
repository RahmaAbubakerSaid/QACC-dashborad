<?php
require 'database.php';

// تحقق مما إذا كان الطلب هو POST
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // استلام البيانات من الـ POST
    $username = $_POST['created_by'];
    $fileName = $_POST['fileName'];
    $fileUrl = $_POST['fileUrl'];
    $archiveType = $_POST['archiveType'];
    $sequence = $_POST['sequence'];
    $referenceNumber = $_POST['referenceNumber'];
    $date = $_POST['date'];
    $decisionNumber = $_POST['decisionNumber'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $documentType = $_POST['documentType'];
    $attachments = $_POST['attachments'];
    $messageSubject = $_POST['messageSubject'];

    // تجهيز الاستعلام لإدخال البيانات في جدول Archival
    $stmt = $conn->prepare("INSERT INTO Archival (file_name, file_url, archive_type, sequence, reference_number, date, decision_number, from_department, to_department, document_type, attachments, message_subject, created_by) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // ربط البيانات مع الاستعلام
    $stmt->bind_param("sssssssssssss", $fileName, $fileUrl, $archiveType, $sequence, $referenceNumber, $date, $decisionNumber, $from, $to, $documentType, $attachments, $messageSubject, $username);

    // تنفيذ الاستعلام لإدخال البيانات
    if ($stmt->execute()) {
        // إذا تم الإدخال بنجاح، نقوم بتحديث حالة الأرشفة في جدول messages
        $updateStmt = $conn->prepare("UPDATE messages SET archive_status = 'مؤرشفة' WHERE file_name = ? AND file_url = ?");
        $updateStmt->bind_param("ss", $fileName, $fileUrl);

        // تنفيذ استعلام التحديث
        if ($updateStmt->execute()) {
            $response = array('status' => 'success', 'message' => 'Data inserted and messages archived successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to update archive status');
        }

        // إغلاق البيان الخاص بالتحديث
        $updateStmt->close();
    } else {
        $response = array('status' => 'error', 'message' => 'Failed to insert data');
    }

    // إغلاق البيان والاتصال بقاعدة البيانات
    $stmt->close();
    $conn->close();

    // إرسال الرد كـ JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // الرد في حال كانت طريقة الطلب غير صحيحة
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}
?>
