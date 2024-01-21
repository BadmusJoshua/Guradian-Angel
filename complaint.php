<?php
require_once 'inc/header/client-header.php' ?>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">

            <div class="row">
                <div class="col-lg-12 ">
                    <div class=" w-100">
                        <h5 class="card-title fw-semibold mb-4">Make Report</h5>

                        <div class="card-body p-4">
                            <form class="d-flex flex-column gap-2 justify-content-evenly needs-validation" method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" novalidate>

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom04" class="form-label">Report Category</label>
                                            <select class="form-select" id="validationCustom04" required>
                                                <option selected>Category of the report</option>
                                                <option value="1">Sexual Abuse</option>
                                                <option value="2">Child Labour</option>
                                                <option value="3">Trafficking and Exploitation</option>
                                                <option value="4">Medical Neglect</option>
                                                <option value="5">Abandonment</option>
                                                <option value="6">Physical Abuse</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a category.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom03" class="form-label">Incidence Report</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="detailed incidence report" required>
                                            <div class="invalid-feedback">
                                                Please give a detailed report of the incidence.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label for="validationCustom03" class="form-label">Incidence Location</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="detailed address" required>
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
                                            <select class="form-select" id="validationCustom04" required>
                                                <option selected>Open this select menu</option>
                                                <option value="1">I just noticed it</option>
                                                <option value="2">Once in a while</option>
                                                <option value="3">Regularly</option>
                                                <option value="4">Everytime</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please give a detailed report of the incidence.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom04" class="form-label">Have you reported this incidence before?</label>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="example" id="exampleRadios1" value="option1" checked required>
                                                <label class="form-check-label" for="exampleRadios1">
                                                    yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="example" id="exampleRadios2" value="option2" required>
                                                <label class="form-check-label" for="exampleRadios2">
                                                    No
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom03" class="form-label">If yes, what was done?</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Please give a detailed address.
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Are they other witnesses to this event?</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked required>
                                                <label class="form-check-label" for="exampleRadios1">
                                                    yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" required>
                                                <label class="form-check-label" for="exampleRadios2">
                                                    No
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" required>
                                                <label class="form-check-label" for="exampleRadios2">
                                                    Uncertain
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom03" class="form-label">Relation</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="how are you related to the victim?" required>
                                            <div class="invalid-feedback">
                                                Please give a detailed address.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label for="formFileMultiple" class="form-label">Upload evidence if available</label>
                                            <input class="form-control" type="file" id="formFileMultiple" multiple>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <button class="btn btn-dark" name="report">Report</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

<script src="js/bootstrap.min.js"></script>