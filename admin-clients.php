<?php
include 'inc/header/admin-header.php';
//disable client
if (isset($_POST['disable'])) {
    $id = $_POST['id'];
    $sql = "UPDATE clients SET status = '0' WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}
//enable client
if (isset($_POST['enable'])) {
    $id = $_POST['id'];
    $sql = "UPDATE clients SET status = '1' WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}
?>


<div class="container-fluid">
    <!--  Row 1 -->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body w-100">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9 w-100">
                        <div class="table-responsive w-100">
                            <h5 class="card-title fw-semibold text-center">List of Users</h5>
                            <table class="table text-wrap mb-0 align-middle w-100">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Id</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Name</h6>
                                        </th>

                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Status</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Created at</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Updated at</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Actions</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //sql query to fetch all rows in the client table
                                    $sql = "SELECT * FROM clients";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if ($clients) {
                                        foreach ($clients as $details) :
                                    ?>
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0"><?= $details['id'] ?></h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1"><?= $details['name'] ?></h6>
                                                    <span>
                                                        <mute><?= $details['email'] ?></mute>
                                                    </span>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal"><?php if ($details['status'] === 1) { ?>
                                                    <h6 class="fw-semibold mb-1 text-success">Active</h6>
                                                <?php  } else {
                                                                                    echo '<h6 class="fw-semibold mb-1 text-danger">Disabled</h6>';
                                                                                } ?></p>
                                                </td>

                                                <td class="border-bottom-0">
                                                    <h6> <?= $details['created_at'] ?></h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6> <?= $details['updated_at'] ?></h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                                                        <input type="hidden" name="id" value="<?= $details['id'] ?>">

                                                        <?php if ($details['status'] === 1) { ?>
                                                            <button class="btn btn-sm btn-danger" name="disable">Disable</button>
                                                        <?php  } else { ?>
                                                            <button class="btn btn-sm btn-primary" name="enable">Enable</button>
                                                        <?php } ?>
                                                    </form>
                                                </td>
                                            </tr>
                                    <?php endforeach;
                                    } else {
                                        echo '<div class="alert alert-danger text-center" role="alert">
                    Oops! No clients yet!s
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
</div>
<?php
include 'inc/footer/admin-footer.php'; ?>