<?php
require 'inc/header/admin-header.php';


if (isset($_GET['id'])) {
    $complaintId = $_GET['id'];
    $sql = "UPDATE complaints SET attended = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['1', $messageId]);
} else {
    //redirect to complaint log
    header("Location:admin-complaint.php");
}
$sql = "SELECT * FROM complaints WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$complaintId]);
$complaintDetails = $stmt->fetch();


if (isset($_POST['invalid'])) {
    $sql = "UPDATE complaints SET isValid = ?, attended = ? , attendedBy = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['0', '1', $adminId, $complaintId]);
}
if (isset($_POST['valid'])) {
    $sql = "UPDATE complaints SET isValid = ?, attended = ? , attendedBy = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['1', '1', $adminId, $complaintId]);
}
if (isset($_POST['report'])) {
    //fetch attachment file
    $sql = "SELECT evidence FROM complaints WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$complaintId]);
    $fileData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fileData) {
        $filePath = $fileData['evidence'];

        // Step 2: Read the file contents
        $fileContents = file_get_contents($filePath);

        if ($fileContents !== false) {
            // Step 3: Output the file contents
            // Set appropriate headers
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));

            // Output the file contents
            echo $fileContents;
            exit;
        } else {
            // Error handling if unable to read file
            echo "Error: Unable to read file.";
        }
    } else {
        // Error handling if file ID is invalid or not found
        echo "Error: File not found.";
    }

    $sql = "UPDATE complaints SET forward = ?, attended = ? , attendedBy = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['1', '1', $adminId, $complaintId]);
}
?>

<body>
    <!--  Body Wrapper -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100 p-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Complaint Id: <?= $complaintId ?></h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="col-12 text-center border-primary-subtle border-top-1 border-bottom-1 d-flex flex-column ">
                            <h5 class="font-semibold">Abuse Category: <?= $complaintDetails->category ?></h5>
                            <span class="fs-4 ">Reported by: <?php $sqli = "SELECT * FROM clients WHERE id = ?";
                                                                $stmti = $pdo->prepare($sqli);
                                                                $stmti->execute([$complaintDetails->complainerId]);
                                                                $complainerDetails = $stmti->fetch();
                                                                echo $complainerDetails->name;
                                                                ?>
                            </span>
                            <span class="fs-2 fw-bolder ">
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
                            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])  ?>" method="post" class="d-flex gap-2 justify-content-between">

                                <?php
                                if ($complaintDetails->forward == "0") {
                                    if ($complaintDetails->isValid == "1") {
                                        echo '<button class="btn btn-warning" name="invalid">Not Valid</button>';
                                    } else {
                                        echo "<button class='btn btn-success' name='valid'>Valid</button>";
                                    }
                                    echo "<button class='btn btn-primary' name='report'>Report</button>";
                                } else {
                                    echo "<button class='btn btn-secondary disabled' name='report'>Reported!</button>";
                                };
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