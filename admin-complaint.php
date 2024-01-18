<?php
include 'inc/header/admin-header.php';
?>
<!--  Header End -->
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
                                        <h6 class="fw-semibold mb-0">Id</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Name</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Category</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Message</h6>
                                    </th>

                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Date</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Actions</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = 'SELECT * FROM complaints WHERE attended = 0';
                                $stmt = $pdo->prepare($sql);
                                // $stmt->execute([$userId]);
                                $logs = $stmt->fetchAll();
                                $n = 0;
                                if ($logs) {
                                    foreach ($logs as $details) :
                                ?>
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0"><?= $n++ ?></h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1"><?= $details->complainerName ?></h6>
                                                <span class="fw-normal"><?= $details->complainerOccupation ?></span>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-normal"><?= $details->category ?></p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <div class="d-flex align-items-center gap-2">
                                                    <?= $details->valid ?>
                                                    <span class="badge bg-primary rounded-3 fw-semibold">Low</span>
                                                </div>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0 fs-4"> <?= $details->dateTime ?></h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0 fs-4"> <button class="btn btn-sm btn-primary">Valid</button><button class="btn btn-sm btn-secondary">Respond</button><button class="btn btn-sm btn-secondary">View</button></h6>
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
</div>
<?php
include 'inc/footer/admin-footer.php';
?>