<?php
session_start(); // بدء الجلسة

// تحقق مما إذا كانت صلاحيات المستخدم موجودة في الجلسة
$permissions = isset($_SESSION['permissions']) ? $_SESSION['permissions'] : [];
?>

<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.html" class="d-flex align-items-center ms-4 mb-4">
            <img src="img/qacc.png" alt="شعار الموقع" style="width: 100px; height: 65px; margin-bottom: 15px;">
            <h6 class="text-primary">مركز ضمان الجودة والمعايرة المهنية</h6>
        </a>

        <div class="navbar-nav w-100">
            <?php if (isset($permissions['لوحة التحكم'])) { ?>
                <a href="index.html" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>إحصائيات</a>
            <?php } ?>

            <!-- مدير النظام -->
            <?php if (isset($permissions['مدير النظام'])) { ?>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-solid fa-user-tie me-2"></i>مدير النظام
                    </a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <!--المتغير $action -->
                        <!--هو متغير يُستخدم لتمثيل كل قيمة داخل المصفوفة المتداخلة التي تعود لمفتاح 'مدير النظام' -->
                        <?php foreach ($permissions['مدير النظام'] as $action) { ?>
                            <?php if ($action === 'إدارة حسابات مستخدمي لوحة التحكم') { ?>
                                <a href="system-administrator.html" class="dropdown-item">إدارة حسابات مستخدمي لوحة التحكم</a>
                            <?php } ?>
                            <?php if ($action === 'إدارة الصلاحيات') { ?>
                                <a href="permissions.html" class="dropdown-item">إدارة الصلاحيات</a>
                            <?php } ?>
                            <?php if ($action === 'إدارة الإدارات') { ?>
                                <a href="administration-of-depatments.html" class="dropdown-item">إدارة الإدارات</a>
                            <?php } ?>
                            <?php if ($action === 'إدارة المكاتب') { ?>
                                <a href="officeManagement.html" class="dropdown-item">إدارة المكاتب</a>
                            <?php } ?>
                            <?php if ($action === 'إدارة طلبات الأصناف') { ?>
                                <a href="categories_admin.html" class="dropdown-item">إدارة طلبات الأصناف</a>
                            <?php } ?>
                            <?php if ($action === 'إدارة طلبات النماذج') { ?>
                                <a href="forms_requests_admin.html" class="dropdown-item">إدارة طلبات النماذج</a>
                            <?php } ?>
                            <?php if ($action === 'إدارة الموظفين') { ?>
                                <a href="manage_employees_admin.html" class="dropdown-item">إدارة الموظفين</a>
                            <?php } ?>
                            <?php if ($action === 'الحضور والانصراف') { ?>
                                <a href="attendance-and-departure-admin.html" class="dropdown-item">الحضور والانصراف</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <!-- رئيس شؤون الموظفين -->
            <?php if (isset($permissions['رئيس شؤون الموظفين'])) { ?>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-solid fa-users me-2"></i>رئيس شؤون الموظفين
                    </a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <?php foreach ($permissions['رئيس شؤون الموظفين'] as $action) { ?>
                            <?php if ($action === 'إدارة الموظفين') { ?>
                                <a href="manage_employees.html" class="dropdown-item">إدارة الموظفين</a>
                            <?php } ?>
                            <?php if ($action === 'الإجازات') { ?>
                                <a href="leaveNotifications.html" class="dropdown-item">الإجازات</a>
                            <?php } ?>
                            <?php if ($action === 'الحضور والانصراف') { ?>
                                <a href="attendance-and-departure.html" class="dropdown-item">الحضور والانصراف</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <!-- مدير إدارة الشؤون الإدارية والمالية -->
            <?php if (isset($permissions['مدير إدارة الشؤون الإدارية والمالية'])) { ?>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-money-bill-wave me-2"></i>مدير إدارة الشؤون الإدارية والمالية
                    </a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <?php foreach ($permissions['مدير إدارة الشؤون الإدارية والمالية'] as $action) { ?>
                            <?php if ($action === 'إدارة طلبات الأصناف') { ?>
                                <a href="categories.html" class="dropdown-item">إدارة طلبات الأصناف</a>
                            <?php } ?>
                            <?php if ($action === 'إدارة طلبات النماذج') { ?>
                                <a href="forms_requests.html" class="dropdown-item">إدارة طلبات النماذج</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <!-- أمين المخازن -->
            <?php if (isset($permissions['أمين المخازن'])) { ?>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-solid fa-box-open me-2"></i>أمين المخازن
                    </a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <?php foreach ($permissions['أمين المخازن'] as $action) { ?>
                            <?php if ($action === 'إدارة طلبات الأصناف') { ?>
                                <a href="receive_categories_manager.html" class="dropdown-item">إدارة طلبات الأصناف</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <!-- رئيس وحدة المحفوظات -->
            <?php if (isset($permissions['رئيس وحدة المحفوظات'])) { ?>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-solid fa-envelope-open-text me-2"></i>رئيس وحدة المحفوظات
                    </a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <?php foreach ($permissions['رئيس وحدة المحفوظات'] as $action) { ?>
                            <?php if ($action === 'إدارة الرسائل') { ?>
                                <a href="archives.html" class="dropdown-item">إدارة الرسائل</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <!-- قسم الإعلانات -->
            <?php if (isset($permissions['قسم الإعلانات'])) { ?>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa fa-bullhorn me-2"></i>قسم الإعلانات
                    </a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <?php foreach ($permissions['قسم الإعلانات'] as $action) { ?>
                            <?php if ($action === 'إدارة الإعلانات') { ?>
                                <a href="ads.html" class="dropdown-item">إدارة الإعلانات</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <!-- صفحات إضافية -->
            <?php if (isset($permissions['Pages'])) { ?>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="far fa-file-alt me-2"></i>Pages
                    </a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <?php foreach ($permissions['Pages'] as $action) { ?>
                            <?php if ($action === 'Sign In') { ?>
                                <a href="signin.html" class="dropdown-item">Sign In</a>
                            <?php } ?>
                            <?php if ($action === 'Sign Up') { ?>
                                <a href="signup.html" class="dropdown-item">Sign Up</a>
                            <?php } ?>
                            <?php if ($action === '404 Error') { ?>
                                <a href="404.html" class="dropdown-item">404 Error</a>
                            <?php } ?>
                            <?php if ($action === 'Blank Page') { ?>
                                <a href="blank.html" class="dropdown-item">Blank Page</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </nav>
</div>
<!-- Sidebar End -->