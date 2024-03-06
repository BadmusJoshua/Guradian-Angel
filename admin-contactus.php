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
                        <table class="table text-wrap mb-0 align-middle  text-dark fs-4" style="max-width:100%;">

                            <?php
                            $sql = 'SELECT * FROM contactus ORDER BY created DESC , isRead ASC  ';
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([]);
                            $logs = $stmt->fetchAll();
                            $n = 1;
                            if ($logs) { ?>
                                <thead class="text-dark fs-4 ">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">S/N</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Name</h6>
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
                                    <?php foreach ($logs as $details) :
                                    ?>
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0"><?= $n++ ?></h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1 text-center"><?= $details->fullname ?></h6>
                                                <span class="fs-2 text-center"><?= $details->email ?></span>
                                            </td>
                                            <!-- <td class="border-bottom-0">
                                                <h6 class="fw-normal mb-0"></h6>
                                            </td> -->
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-normal text-justify text-wrap"><?= $details->message ?></p>
                                            </td>

                                            <td class="border-bottom-0">
                                                <h6 class="fw-normal mb-0 fs-2"> <?php
                                                                                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $details->created);
                                                                                    echo $date->format('D d M, Y H:i:s');
                                                                                    ?>

                                                </h6>
                                            </td>
                                            <td class="border-bottom-0">

                                                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                                                    <?php if ($details->replied == '0') {
                                                        echo "<a href='admin-view-messages.php?id=$details->id' class='btn btn-sm btn-secondary'>Reply</a>";
                                                    } else {
                                                        echo '<button class="btn btn-dark btn-sm disabled">Replied!</button>';
                                                        echo "<a href='admin-view-messages.php?id=$details->id' class='btn btn-sm btn-light'>View</a>";
                                                    }
                                                    ?>

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
<?php
include 'inc/footer/admin-footer.php'; ?>