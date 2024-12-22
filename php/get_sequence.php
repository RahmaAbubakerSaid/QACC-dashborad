<?php
require 'database.php';

// الحصول على السنة الحالية
$currentYear = date("Y");

// استعلام للحصول على العدد الحالي للرسائل المؤرشفة
$sql = "SELECT COUNT(*) AS sequence FROM Archival";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    // إضافة السنة إلى التسلسل
    $sequence = $row['sequence'] + 1;
    $formattedSequence = $currentYear . '/' . $sequence;

    $response = array('status' => 'success', 'sequence' => $formattedSequence);
} else {
    $response = array('status' => 'error', 'message' => 'Failed to fetch sequence');
}

// إرجاع النتيجة كـ JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>

