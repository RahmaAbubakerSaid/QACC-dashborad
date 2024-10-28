<?php
session_start();
session_destroy(); // تدمير الجلسة
header("Location: http://localhost/QACC-dashborad/signin.html"); // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول
exit();
?>