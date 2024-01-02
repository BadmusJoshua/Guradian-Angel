<?php require_once 'inc/config/database.php';
session_start();
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
}

$sql = "SELECT * FROM applicants WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$detail = $stmt->fetch();
$userCategory = $detail->category;
$job = $detail->job_category;
$image = $detail->image;
$name = ucwords($detail->name);
$name_array = explode(' ', $name);
$last_name = end($name_array);
$first_name = $name_array[0];
$initial = substr($first_name, 0, 1);
$official_name = "$initial . $last_name";

//fetching all notifications pertaining to this user
$sql = "SELECT * FROM notifications WHERE is_read=0 && id=$userId && category = $userCategory";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$content = $stmt->fetchAll();
$notification_count = $stmt->rowCount();


//setting all notifications as read
if (isset($_POST['view_all'])) {
    $sql = "UPDATE notifications SET is_read=1 WHERE id = $userId && category = $userCategory";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:100,300,400,500,700,900&amp;display=swap" rel="stylesheet" />

    <!-- Template CSS Files -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/line-awesome.css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" href="css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="css/magnific-popup.css" />
    <link rel="stylesheet" href="css/daterangepicker.css" />
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <link rel="stylesheet" href="css/chosen.min.css" />
    <link rel="stylesheet" href="css/style.css" />

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <title> JobCrest || The best job openings</title>
</head>

<body>
    <!-- /**********
              * HEADER *
              **********/ -->
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center" style="visibility:none;">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center ">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">Jobcrest</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar justify-content-center">
            <form class="search-form d-flex align-items-center" method="POST" action="search.php">
                <input type="text" name="query" placeholder="Enter Search Keyword">
                <button name="search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <!-- /***********
              * NAV BAR *
              ***********/ -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>
                <!-- End Search Icon  -->



                <li class="nav-item dropdown" id="nav_icon">

                    <a class="nav-link  get_noti nav-icon" id="nav_icon" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number" Id="notification_count"></span>
                    </a><!-- End Notification Icon -->


                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications overflow-auto" id="container" style="max-height:60vh;">

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->


                <!-- /*********************
              * POST NOTIFICATION *
              *********************/ -->

                <!-- /*********************
          * POST NOTIFICATION *
          *********************/ -->


                <!-- /******************
                * AVATAR DETAILS *
                ******************/ -->
                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="assets/uploads/images/<?php echo $image ?>" onerror="this.src='assets/img/profile-img.jpg'" alt="Profile" class="rounded-circle" style="height:30px;width:30px;">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $official_name; ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $name ?></h6>
                            <span><?php echo $job ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="applicant-profile.php">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="profile.php">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="bi bi-question-circle"></i>
                                <span>Need Help?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

                <!-- /******************
                * AVATAR DETAILS *
                ******************/ -->

            </ul>
        </nav><!-- End Icons Navigation -->

        <!-- /***********
              * NAV BAR *
              ***********/ -->

    </header><!-- End Header -->


    <!-- /**********
              * HEADER *
              **********/ -->
    <script src="assets/vendor/jquery.min.js"></script>
    <script>
        //load notification counter 
        function loadCount() {
            setTimeout(function() {

                fetch('notification_count.php').then(res => {
                    console.log(res);
                    if (res.ok) {
                        return res.json();
                    } else {
                        throw (new Error);
                    }
                }).then(data => {
                    console.log(data);
                    document.getElementById("notification_count").innerHTML = data.count;
                }).catch(e => {
                    console.log(e);
                })

            }, 1000);
        }

        $(document).ready(function() {
            $("#nav_icon").click(function() {
                $("#container").load("notification_fetch.php");
            });
        });


        loadCount();
    </script>