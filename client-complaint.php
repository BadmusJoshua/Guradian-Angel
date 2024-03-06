<?php
require 'inc/header/client-header.php';



$sql = "SELECT * FROM complaints WHERE complainerId = ? ORDER BY created_at ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$complaintDetails = $stmt->fetchAll();

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100 p-4">
                <div class="card-header">
                    <div class="card-title">
                        <h4>My Complaints</h4>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="col-12 text-center border-primary-subtle border-top-1 border-bottom-1 d-flex flex-column ">
                        <?php if ($complaintDetails) { ?>
                            <?php foreach ($complaintDetails as $complaint) { ?>
                                <div class="col  mb-2">
                                    <span class="fs-2 fw-bolder d-flex m-auto text-center">
                                        <?php
                                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $complaint->created_at);
                                        echo $date->format('D d M, Y H:i:s');
                                        ?>
                                    </span>
                                    <h5 class='text-justify rounded text-dark fw-semibold p-4' style="background-color: #49BEFF; width:fit-content;"><?= $complaint->report ?></h5>

                                </div>

                                <div class="d-flex flex-row ">
                                    <?php
                                    if ($complaint->attended == '0') { ?>
                                        <span class="badge bg-light rounded-3 fw-semibold text-primary">Unattended </span>
                                    <?php } else { ?>
                                        <span class="badge bg-light rounded-3 fw-semibold text-primary">Attended </span>

                                    <?php } ?>
                                    <?php
                                    if ($complaint->isValid == '1') { ?>

                                        <span class="badge bg-light rounded-3 fw-semibold text-success">Valid</span>
                                    <?php } else { ?>
                                        <span class="badge bg-light rounded-3 fw-semibold text-warning">Invalid</span>
                                    <?php } ?>
                                    <?php
                                    if ($complaint->reported == '1') { ?>

                                        <span class="badge bg-light rounded-3 fw-semibold text-success">Reported</span>
                                    <?php } else { ?>
                                        <span class="badge bg-light rounded-3 fw-semibold text-warning">Not Reported</span>


                                    <?php } ?>

                                </div>
                            <?php  } ?>
                        <?php } else { ?>
                            <div class="alert alert-danger text-center" role="alert">
                                You haven't made any complaint yet!
                            </div>
                        <?php } ?>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <?php
    include 'inc/footer/admin-footer.php';
    ?>