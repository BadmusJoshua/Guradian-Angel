<?php
include 'inc/header/admin-header.php';
?>
<!--  Header End -->

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 d-flex align-items-stretch">
                        <div class="card w-100">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-semibold mb-4">Recent Reports</h5>
                                <div class="table-responsive">
                                    <table class="table text-nowrap mb-0 align-middle">
                                        <thead class="text-dark fs-4">
                                            <tr>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 text-center">S/N</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 text-center">Reporter's Name</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 text-center">Category</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 text-center">Report</h6>
                                                </th>

                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 text-center">Date</h6>
                                                </th>
                                                <th class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0 text-center">Actions</h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM complaints";
                                            $stmt = $pdo->prepare($sql);
                                            $stmt->execute([]);
                                            $logs = $stmt->fetchAll();
                                            $n = 1;
                                            if ($logs) {
                                                foreach ($logs as $details) :
                                            ?>
                                                    <tr>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0"><?= $n++ ?></h6>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-1"><?php
                                                                                            $sqli = "SELECT * FROM clients WHERE id = ?";
                                                                                            $stmti = $pdo->prepare($sqli);
                                                                                            $stmti->execute([$details->complainerId]);
                                                                                            $complainerDetails = $stmti->fetch();
                                                                                            echo $complainerDetails->name;
                                                                                            ?>
                                                            </h6>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <h6 class="mb-1 fw-semibold"><?= $details->category ?></>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <div class="d-flex align-items-center text-justify text-wrap">
                                                                <?= $details->report ?>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <small class="fw-normal mb-0 fs-2"> <?php $details->created_at;
                                                                                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $details->created_at);
                                                                                                echo $date->format('d M, Y H:i:s');
                                                                                                ?></small>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <a href="view-complaint.php?id=<?= $details->id; ?>" class="btn btn-sm btn-primary">View</a>
                                                        </td>
                                                    </tr>
                                            <?php endforeach;
                                            } else {
                                                echo '<div class="alert alert-danger text-center" role="alert">
                    Oops! No complaints yet, check later.
                  </div>';
                                            }
                                            ?>





                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            include 'inc/footer/admin-footer.php';
            ?>