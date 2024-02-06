<?php
require_once 'inc/header/client-header.php';
$category = $report = $address = $rate = $reported = $actions = $witnesses = $witnessContact = $relation = $evidence = '';

$sent = 0; // Initialize $sent to 0

if (isset($_POST['make-report'])) {
    // Sanitize and retrieve form data
    $category = !empty($_POST['category']) ? filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
    $report = !empty($_POST['report']) ? filter_input(INPUT_POST, 'report', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
    $address = !empty($_POST['address']) ? filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
    $rate = !empty($_POST['rate']) ? filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
    $reported = !empty($_POST['reported']) ? filter_input(INPUT_POST, 'reported', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
    $actions = !empty($_POST['actions']) ? filter_input(INPUT_POST, 'actions', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
    $witnesses = !empty($_POST['witnesses']) ? filter_input(INPUT_POST, 'witnesses', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
    $witnessContact = !empty($_POST['witnessContact']) ? filter_input(INPUT_POST, 'witnessContact', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
    $relation = !empty($_POST['relation']) ? filter_input(INPUT_POST, 'relation', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
    $userId = $_SESSION['id'];
    // File upload handling

    // if (!empty($_FILES['evidence']['tmp_name'])) {
    //     // Move uploaded file to permanent location
    //     $uploadDirectory = 'uploads/'; // Specify your upload directory
    //     $uploadFile = $uploadDirectory . basename($_FILES['evidence']['name']);
    //     move_uploaded_file($_FILES['evidence']['tmp_name'], $uploadFile);
    //     $evidence = $uploadFile; // Store path to the file in $evidence
    // } else {
    //     $evidence = ''; // Set $evidence to empty string if no file was uploaded
    // }

    if (!empty($_FILES['evidence']['tmp_name'])) {
        $fileExt = strtolower(pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION));
        $fileName = uniqid('complaint_evidence') . '.' . $fileExt;
        $uploadDirectory = 'uploads/evidence';

        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        $uploadFile = $uploadDirectory . '/' . $fileName;
        $acceptedExt = array('jpeg', 'jpg', 'png');


        if (in_array($fileExt, $acceptedExt)) {
            move_uploaded_file($_FILES['evidence']['tmp_name'], $uploadFile);
            $evidence = $uploadFile;
        } else {
            $fileErr = 1;
        }
    } else {
        $evidence = '';
    }

    // Prepare and execute SQL query
    $sql = "INSERT INTO complaints (complainerId, category, report, evidence, address, rate, reported, actions, witnesses, witnessContact, relation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId, $category, $report, $evidence, $address, $rate, $reported, $actions, $witnesses, $witnessContact, $relation]);

    // Set $sent to 1 after successful submission
    $sent = 1;
}
?>


<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">

            <div class="row">
                <div class="col-lg-12 ">
                    <div class=" w-100 card">
                        <h5 class="card-title fw-semibold mb-4">Make Report</h5>

                        <div class="p-4 card-body">
                            <form class="d-flex flex-column gap-2 justify-content-evenly needs-validation" method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" novalidate>
                                <h5 class="card-title fw-semibold mb-4 text-center">Make Report</h5>

                                <?php

                                if ($sent) {
                                    echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                          Your complaint has been submitted 
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                                }
                                ?>

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom04" class="form-label">Report Category</label>
                                            <select class="form-select" name="category" id="validationCustom04" required>
                                                <option value="" <?php if ($category === "")
                                                                        echo "selected";
                                                                    ?>>Category of the report</option>
                                                <option value="Sexual Abuse" <?php if ($category === "Sexual Abuse")
                                                                                    echo "selected";
                                                                                ?>>Sexual Abuse</option>
                                                <option value="Child Labour" <?php if ($category === "Child Labour")
                                                                                    echo "selected";
                                                                                ?>>Child Labour</option>
                                                <option value="Trafficking and Exploitation" <?php if ($category === "Trafficking and Exploitation")
                                                                                                    echo "selected";
                                                                                                ?>>Trafficking and Exploitation</option>
                                                <option value="Medical Neglect" <?php if ($category === "Medical Neglect")
                                                                                    echo "selected";
                                                                                ?>>Medical Neglect</option>
                                                <option value="Abandonment" <?php if ($category === "Abandonment")
                                                                                echo "selected";
                                                                            ?>>Abandonment</option>
                                                <option value="Physical Abuse" <?php if ($category === "Physical Abuse")
                                                                                    echo "selected";
                                                                                ?>>Physical Abuse</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a category.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom03" class="form-label">Incidence Report</label>
                                            <textarea name="report" class="form-control" id="validationCustom03" placeholder="detailed incidence report" id="" cols="30" rows="5" value="<?= $report; ?>" required></textarea>
                                            <div class="invalid-feedback">
                                                Please give a detailed report of the incidence.
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label for="validationCustom03" class="form-label">Incidence
                                                Location</label>
                                            <textarea name="address" class="form-control" id="validationCustom03" placeholder="detailed address" id="" cols="30" rows="5" value="<?= $address; ?>" required></textarea>
                                            <div class="invalid-feedback">
                                                Please give a detailed address.
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="validationCustom04" class="form-label">Incidence Rate</label>
                                            <select class="form-select" name="rate" id="validationCustom04" required>
                                                <option value="" <?php if ($rate == "")
                                                                        echo "selected";
                                                                    ?>>Open this select menu</option>
                                                <option value="I just noticed it" <?php if ($rate == "I just noticed it")
                                                                                        echo "selected";
                                                                                    ?>>I just noticed it</option>
                                                <option value="Once in a while" <?php if ($rate == "Once in a while")
                                                                                    echo "selected";
                                                                                ?>>Once in a while</option>
                                                <option value="Regularly" <?php if ($rate == "Regularly")
                                                                                echo "selected";
                                                                            ?>>Regularly</option>
                                                <option value="Everytime" <?php if ($rate == "Everytime")
                                                                                echo "selected";
                                                                            ?>>Everytime</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please give a detailed report of the incidence.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom04" class="form-label">Have you reported this
                                                incidence before?</label>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="reported" id="exampleRadios1" value="yes" <?php if ($reported == "yes")
                                                                                                                                                    echo "checked";
                                                                                                                                                ?> required>
                                                <label class="form-check-label" for="exampleRadios1">
                                                    yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="reported" id="exampleRadios2" value="no" <?php if ($reported == "no")
                                                                                                                                                echo "checked";
                                                                                                                                            ?> required>
                                                <label class="form-check-label" for="exampleRadios2">
                                                    No
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom03" class="form-label">If yes, what was
                                                done?</label>

                                            <textarea name="actions" id="" cols="30" rows="5" class="form-control" id="validationCustom03" placeholder="detailed account of actions taken" value="<?php echo $actions; ?>"></textarea>
                                            <div class="invalid-feedback">
                                                Please give a detailed address.
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom03" class="form-label">Are they other witnesses
                                                to this event?</label>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="witnesses" id="exampleRadios1" value="yes" <?php if ($witnesses == "yes") {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?> required>
                                                <label class="form-check-label" for="exampleRadios1">
                                                    yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="witnesses" id="exampleRadios2" value="no" <?php if ($witnesses == "no") {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?>required>
                                                <label class="form-check-label" for="exampleRadios2">
                                                    No
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="witnesses" id="exampleRadios2" value="uncertain" <?php if ($witnesses == "uncertain") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> required>
                                                <label class="form-check-label" for="exampleRadios2">
                                                    Uncertain
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom03" class="form-label">Witness' contact</label>
                                            <textarea name="" id="validationCustom03" cols="30" rows="5" class="form-control" name="witnessContact" placeholder="how can we reach the witnesses?" value="<?= $witnessContact ?>"></textarea>
                                            <div class="invalid-feedback">
                                                Please, tell us how you are related to the victim.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom03" class="form-label">Relation</label>
                                            <input type="text" class="form-control" id="validationCustom03" name="relation" placeholder="how are you related to the victim?" value="<?= $relation ?>" required>
                                            <div class="invalid-feedback">
                                                Please, tell us how you are related to the victim.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            <label for="formFileMultiple" class="form-label">Upload evidence if
                                                available</label>
                                            <input class="form-control" name="evidence" type="file" id="formFileMultiple" multiple>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <button class="btn btn-dark" name="make-report">Report</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
<?= $sent, $category, $report, $address, $rate, $reported, $actions, $witnesses, $witnessContact, $relation, $evidence ?>

<script src="js/bootstrap.min.js"></script>