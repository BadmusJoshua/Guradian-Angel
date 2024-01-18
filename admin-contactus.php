<?php include 'inc/header/admin-header.php';
//mark message as seen
if (isset($_POST['seen'])) {
    $id = $_POST['id'];
    $sql = 'UPDATE contactus SET isRead = 1 WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}

?>

<div class="container-fluid">
    <!--  Row 1 -->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Guest's Messages</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle " style="max-width:100%;">
                            <thead class="text-dark fs-4 ">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">S/N</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Name</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Email</h6>
                                    </th>
                                    <th class="border-bottom-0 ">
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
                                $sql = 'SELECT * FROM contactus WHERE isRead = ? ORDER BY created DESC ';
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute(['0']);
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
                                                <h6 class="fw-semibold mb-1"><?= $details->fullname ?></h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-normal mb-0"><?= $details->email ?></h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-normal text-justify text-wrap"><?= $details->message ?></p>
                                            </td>

                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0 fs-4"> <?= $details->created ?></h6>
                                            </td>
                                            <td class="border-bottom-0">

                                                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                                                    <input type="hidden" name="id" value="<?= $details->id ?>">
                                                    <button class="btn btn-sm btn-primary" name="seen">seen</button>
                                                    <button class="btn btn-sm btn-secondary">reply</button>
                                                </form>

                                            </td>
                                        </tr>
                                <?php endforeach;
                                } else {
                                    echo '<div class="alert alert-danger text-center" role="alert">
                                    Oops! No messages yet, check later.
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