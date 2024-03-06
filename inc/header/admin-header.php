<?php
require 'inc/config/database.php';
session_start();
if (isset($_SESSION['id'])) {
    $adminId =  $_SESSION['id'];
    $sql = "SELECT * FROM admins WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$adminId]);
    $detail = $stmt->fetch();
    $super_admin = $detail->superadmin;
} else {
    header("Location:admin-login.php");
}

//getting count of each category of Report
$sql = "SELECT * FROM complaints WHERE category = 'Physical Abuse'";
$stmt = $pdo->prepare($sql);
if ($stmt) {
    $stmt->execute([]);
    $physical_abuse = $stmt->rowCount();
} else {
    echo "Error: Unable to process statement";
}
$sql = "SELECT * FROM complaints WHERE category = 'Sexual Abuse'";
$stmt = $pdo->prepare($sql);
if ($stmt) {
    $stmt->execute([]);
    $sexual_abuse = $stmt->rowCount();
} else {
    echo "Error: Unable to process statement";
}
$sql = "SELECT * FROM complaints WHERE category = 'Child Labour'";
$stmt = $pdo->prepare($sql);
if ($stmt) {
    $stmt->execute([]);
    $child_labour = $stmt->rowCount();
} else {
    echo "Error: Unable to process statement";
}
$sql = "SELECT * FROM complaints WHERE category = 'Medical Neglect'";
$stmt = $pdo->prepare($sql);
if ($stmt) {
    $stmt->execute([]);
    $medical_neglect = $stmt->rowCount();
} else {
    echo "Error: Unable to process statement";
}
$sql = "SELECT * FROM complaints WHERE category = 'Abandonment'";
$stmt = $pdo->prepare($sql);
if ($stmt) {
    $stmt->execute([]);
    $abandonment = $stmt->rowCount();
} else {
    echo "Error: Unable to process statement";
}
$sql = "SELECT * FROM complaints WHERE category = 'Trafficking and Exploitation'";
$stmt = $pdo->prepare($sql);
if ($stmt) {
    $stmt->execute([]);
    $Trafficking = $stmt->rowCount();
} else {
    echo "Error: Unable to process statement";
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guardian Angel</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="assets\css\styles.css" />
    <link rel="stylesheet" href="assets\css\icons\tabler-icons\tabler-icons.css" />


    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/aos.css">

</head>


<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar ">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between m-auto sidebar-item">
                    <a href="admin-index.php" class="text-nowrap logo-img text-dark-emphasis fw-bolder fs-14">
                        <img src="assets\images\logos\favicon.png" width="" alt="" /> Guardian Angel
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar " style="overflow:hidden;" data-simplebar="">
                    <ul id="sidebarnav" style="overflow:hidden;">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="admin-index.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="admin-complaint.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-description"></i>
                                </span>
                                <span class="hide-menu">View Complaints</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="admin-contactus.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-cards"></i>
                                </span>
                                <span class="hide-menu">View Messages</span>
                            </a>
                        </li>
                        <?php
                        if ($super_admin === 1) { ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="admin-register.php" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-user-plus"></i>
                                    </span>
                                    <span class="hide-menu">Admins</span>
                                </a>
                            </li>
                        <?php }
                        ?>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="admin-clients.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user-plus"></i>
                                </span>
                                <span class="hide-menu">Clients</span>
                            </a>
                        </li>


                        <li class="sidebar-item" style="position: fixed;
  bottom: 10px;">
                            <a class="sidebar-link" href="admin-logout.php" aria-expanded="false">
                                <span>
                                    <i class="ti ti-login"></i>
                                </span>
                                <span class="hide-menu">Log Out</span>
                            </a>
                        </li>


                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <h5 class="card-title fw-semibold">Welcome <?php echo $detail->username ?></h5>
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">My Account</p>
                                        </a>
                                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-list-check fs-6"></i>
                                            <p class="mb-0 fs-3">My Task</p>
                                        </a>
                                        <a href="./authentication-login.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->