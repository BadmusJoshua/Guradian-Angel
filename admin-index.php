<?php
require_once 'inc/header/admin-header.php';

//sql to get count of complaints
$sql = "SELECT * FROM complaints ";
$stmt = $pdo->prepare($sql);
if ($stmt) {
  $stmt->execute([]);
  $complaints = $stmt->rowCount();
} else {
  echo "Error: Unable to Prepare Statement";
}

//sql to get count of abuse categories by group
$sql = "SELECT category, COUNT (id) AS TOTAL  FROM complaints GROUP BY category";
$stmt = $pdo->prepare($sql);
$stmt->execute([]);
$data = array();
foreach ($data as $row) {
  $data[] = array(
    'category' => $row["category"],
    'total' => $row["total"],
    'color' => '#' . rand(100000, 999999) . ' '
  );
}
echo json_encode($data);
?>




<div class="container-fluid">
  <!--  Row 1 -->
  <div class="row">
    <div class="col-lg-8 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body">
          <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Reports Overview</h5>
            </div>

          </div>
          <div id="chart"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="row">
        <div class="col-lg-12">
          <!-- Yearly Breakup -->
          <div class="card overflow-hidden">
            <div class="card-body p-4">
              <h5 class="card-title mb-9 fw-semibold">Yearly Report</h5>
              <div class="row align-items-center">
                <div class="col-8">
                  <h4 class="fw-semibold mb-3">6,358</h4>
                  <div class="d-flex align-items-center mb-3">
                    <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                      <i class="ti ti-arrow-up-left text-success"></i>
                    </span>
                    <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                    <p class="fs-3 mb-0">last year</p>
                  </div>
                  <div class="d-flex flex-wrap flex-column">
                    <div class="me-4">
                      <span class="round-8 rounded-circle me-2 d-inline-block" style="background-color:#5d87ff;"></span>
                      <span class="fs-2">Physical Abuse</span>
                    </div>
                    <div>
                      <span class="round-8 rounded-circle me-2 d-inline-block" style="background-color:#ed1;"></span>
                      <span class="fs-2">Sexual Abuse</span>
                    </div>
                    <div class="me-4">
                      <span class="round-8 rounded-circle me-2 d-inline-block" style="background-color:#f0f;"></span>
                      <span class="fs-2">Child Labor</span>
                    </div>
                    <div>
                      <span class="round-8 rounded-circle me-2 d-inline-block" style="background-color:#000;"></span>
                      <span class="fs-2">Medical Neglect</span>
                    </div>
                    <div class="me-4">
                      <span class="round-8 rounded-circle me-2 d-inline-block" style="background-color:#ad4;"></span>
                      <span class="fs-2">Abandonment</span>
                    </div>
                    <div>
                      <span class="round-8 rounded-circle me-2 d-inline-block" style="background-color:#ca5;"></span>
                      <span class="fs-2">Trafficking and Exploitation</span>
                    </div>
                  </div>
                </div>
                <div class="col-4 d-flex m-auto justify-content-center align-items-center">
                  <div class="d-flex align-self-center justify-content-center">
                    <div id="doughnut_chart"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <!-- Monthly Earnings -->
          <div class="card">
            <div class="card-body">
              <div class="row align-items-start">
                <div class="col-8">
                  <h5 class="card-title mb-9 fw-semibold"> Monthly Reports </h5>
                  <h4 class="fw-semibold mb-3"><?= $complaints ?></h4>
                  <div class="d-flex align-items-center pb-1">
                    <span class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                      <i class="ti ti-arrow-down-right text-danger"></i>
                    </span>
                    <div id="earnings"></div>
                    <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                    <p class="fs-3 mb-0">last month</p>
                  </div>
                </div>
                <div class="col-4">
                  <div class="d-flex justify-content-end">
                    <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                      <i class="ti ti-currency-dollar fs-6"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <h5 class="card-title fw-semibold mb-4">Recent Complaints</h5>

          <?php
          //fetching unattended reports
          $sql = "SELECT * FROM complaints WHERE attended = ? ORDER BY created_at DESC ";
          $stmt = $pdo->prepare($sql);
          $stmt->execute(['0']);
          $logs = $stmt->fetchAll();

          //fetching attended reports
          $sql = "SELECT * FROM complaints WHERE attended = ? ORDER BY created_at DESC ";
          $stmt = $pdo->prepare($sql);
          $stmt->execute(['1']);
          $atlogs = $stmt->fetchAll();

          $n = 1;
          if ($logs) {  ?>
            <div class="table-responsive">
              <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                  <tr>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">S/N</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Name</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Category</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Valid</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Status</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Date</h6>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($logs as $complaint) :
                  ?>
                    <tr>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-0"><?= $n++ ?></h6>
                      </td>
                      <td class="border-bottom-0">

                        <h6 class="fw-semibold mb-1"><?php
                                                      $sqli = "SELECT * FROM clients WHERE id = ?";
                                                      $stmti = $pdo->prepare($sqli);
                                                      $stmti->execute([$complaint->complainerId]);
                                                      $complainerDetails = $stmti->fetch();
                                                      echo $complainerDetails->name;
                                                      ?></h6>
                        <!-- <span class="fw-normal"><?= $complaint->complainerOccupation ?></span> -->
                      </td>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-normal"><?= $complaint->category ?></p>
                      </td>
                      <td class="border-bottom-0">
                        <div class="d-flex align-items-center gap-2">
                          <?php
                          if ($complaint->isValid == '1') { ?>
                            <span class="badge bg-success rounded-3 fw-semibold">Valid</span>
                          <?php } else { ?>
                            <span class="badge bg-warning rounded-3 fw-semibold">Invalid</span>
                          <?php } ?>
                        </div>
                      </td>
                      <td class="border-bottom-0">
                        <div class="d-flex align-items-center gap-2">
                          <?php
                          if ($complaint->attended == '1') { ?>
                            <span class="badge bg-primary rounded-3 fw-semibold">Attended</span>
                          <?php } else { ?>
                            <span class="badge bg-secondary rounded-3 fw-semibold">Unattended</span>
                          <?php } ?>
                        </div>
                      </td>
                      <td class="border-bottom-0">
                        <h6 class="fw-normal mb-0 w-50 text-wrap text-center gap-1"> <?php $complaint->created_at;
                                                                                      $date = DateTime::createFromFormat('Y-m-d H:i:s', $complaint->created_at);
                                                                                      echo $date->format('d M, Y H:i:s');
                                                                                      ?></h6>
                      </td>
                    </tr>
                  <?php endforeach;
                } elseif ($atlogs) { ?>
                  <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                      <thead class="text-dark fs-4">
                        <tr>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">S/N</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Name</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Category</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Valid</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Status</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Date</h6>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($atlogs as $complaint) :
                        ?>
                          <tr>
                            <td class="border-bottom-0">
                              <h6 class="fw-semibold mb-0"><?= $n++ ?></h6>
                            </td>
                            <td class="border-bottom-0">

                              <h6 class="fw-semibold mb-1"><?php
                                                            $sqli = "SELECT * FROM clients WHERE id = ?";
                                                            $stmti = $pdo->prepare($sqli);
                                                            $stmti->execute([$complaint->complainerId]);
                                                            $complainerDetails = $stmti->fetch();
                                                            echo $complainerDetails->name;
                                                            ?></h6>
                              <!-- <span class="fw-normal"><?= $complaint->complainerOccupation ?></span> -->
                            </td>
                            <td class="border-bottom-0">
                              <p class="mb-0 fw-normal"><?= $complaint->category ?></p>
                            </td>
                            <td class="border-bottom-0">
                              <div class="d-flex align-items-center gap-2">
                                <?php
                                if ($complaint->isValid == '1') { ?>
                                  <span class="badge bg-success rounded-3 fw-semibold">Valid</span>
                                <?php } else { ?>
                                  <span class="badge bg-warning rounded-3 fw-semibold">Invalid</span>
                                <?php } ?>
                              </div>
                            </td>
                            <td class="border-bottom-0">
                              <div class="d-flex align-items-center gap-2">
                                <?php
                                if ($complaint->attended == '1') { ?>
                                  <span class="badge bg-primary rounded-3 fw-semibold">Attended</span>
                                <?php } else { ?>
                                  <span class="badge bg-secondary rounded-3 fw-semibold">Unattended</span>
                                <?php } ?>
                              </div>
                            </td>
                            <td class="border-bottom-0">
                              <h6 class="fw-normal mb-0 w-50 text-wrap text-center gap-1"> <?php $complaint->created_at;
                                                                                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $complaint->created_at);
                                                                                            echo $date->format('d M, Y H:i:s');
                                                                                            ?></h6>
                            </td>
                          </tr>
                      <?php endforeach;
                      } else {
                        echo '<div class="alert alert-danger text-center" role="alert">
                            Oops! No new complaints now, check later.
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