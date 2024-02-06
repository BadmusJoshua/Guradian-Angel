<?php
require 'inc/header/admin-header.php';
if (isset($_GET['id'])) {
    $messageId = $_GET['id'];
} else {
    //redirect to complaint log
    header("Location:admin-contactus.php");
}
$sql = "SELECT * FROM contactus WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$messageId]);
$complaintDetails = $stmt->fetch();


if (isset($_POST['invalid'])) {
    $sql = "UPDATE contactus SET attended = ? , attendedBy = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['1', $adminId, $messageId]);
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Message Id: <?= $messageId ?></h4>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="col-12 text-center border-primary-subtle border-top-1 border-bottom-1 d-flex flex-column ">
                        <h5 class="font-semibold">Abuse Category: <?= $complaintDetails->category ?></h5>
                        <span class="fs-3 ">Reported by: <?php $sqli = "SELECT * FROM clients WHERE id = ?";
                                                            $stmti = $pdo->prepare($sqli);
                                                            $stmti->execute([$complaintDetails->complainerId]);
                                                            $complainerDetails = $stmti->fetch();
                                                            echo $complainerDetails->name;
                                                            ?>
                        </span>
                        <span class="fs-1">
                            <?php $complaintDetails->created_at;
                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $complaintDetails->created_at);
                            echo $date->format('D d M, Y H:i:s');
                            ?>
                        </span>
                    </div>
                </div>

                <div class="col-12">

                    <h6 text-center text-justify> <strong>Incidence Report: </strong> <?= $complaintDetails->report ?></h6>
                </div>

                <div class="col-12">
                    <h6>
                        <strong>Incidence Location:</strong> <?= $complaintDetails->address ?>
                    </h6>
                </div>

                <div class="col-12">
                    <h6>
                        <strong>Occurrence Rate: </strong> <?= $complaintDetails->rate ?>
                    </h6>
                </div>
                <?php
                if ($complaintDetails->reported == "Yes") : ?>
                    <div class="col-12">
                        <h6 text-center text-justify>
                            <strong> Response as last reported: </strong><?= $complaintDetails->actions ?>
                        </h6>
                    </div>
                <?php endif ?>

                <?php
                if ($complaintDetails->witnesses == "Yes") : ?>
                    <div class="col-12 d-flex ">
                        <h6 text-center text-justify>
                            <strong>Witnesses: </bold> <?= $complaintDetails->witnesses ?>
                        </h6>
                        <h6 text-center text-justify>
                            <strong>Witnesses' Contact: </strong> <?= $complaintDetails->witnessContact ?>
                        </h6>
                    </div>
                <?php endif ?>
                <?php
                if ($complaintDetails->evidence) : ?>
                    <div class="col-12 d-flex ">
                        <h6 text-center text-justify> <strong>Evidence: </strong> <?= $complaintDetails->evidence ?></h6>
                    </div>
                <?php endif ?>
                <div class="col-12 border-2">

                    <div class="d-flex flex-row justify-content-center">
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])  ?>" method="post">
                            <button class="btn btn-secondary" name="report">Report </button>
                            <?php
                            if ($complaintDetails->isValid == "1") :
                            ?>
                                <button class="btn btn-warning" name="invalid">Not Valid</button>
                            <?php
                            else :
                                echo "<button class='btn btn-success' name = 'valid'>Valid</button>";
                            endif;
                            ?>

                            <?php
                            if ($complaintDetails->reported == "0") :
                            ?>
                                <button class="btn btn-secondary" name="report">Report</button>
                            <?php
                            else :
                                echo "<button class='btn btn-success disabled' name = 'valid'>Reported</button>";
                            endif;
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'inc/footer/admin-footer.php';
?>