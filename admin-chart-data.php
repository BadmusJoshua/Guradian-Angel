<?php
include 'inc/config/database.php';

//getting count of each category of Report
$sql = "SELECT * FROM complaints WHERE category = 'Physical Abuse'";
$stmt = $pdo->prepare($sql);
if ($stmt) {
    $stmt->execute([]);
    $physical_abuse = $stmt->rowCount();
} else {
    echo "Error: Unable to process statement";
}
$sql = "SELECT * FROM complaints WHERE category = 'Sexual Abuse'";
$stmt = $pdo->prepare($sql);
if ($stmt) {
    $stmt->execute([]);
    $sexual_abuse = $stmt->rowCount();
} else {
    echo "Error: Unable to process statement";
}
$sql = "SELECT * FROM complaints WHERE category = 'Child Labour'";
$stmt = $pdo->prepare($sql);
if ($stmt) {
    $stmt->execute([]);
    $child_labour = $stmt->rowCount();
} else {
    echo "Error: Unable to process statement";
}
$sql = "SELECT * FROM complaints WHERE category = 'Medical Neglect'";
$stmt = $pdo->prepare($sql);
if ($stmt) {
    $stmt->execute([]);
    $medical_neglect = $stmt->rowCount();
} else {
    echo "Error: Unable to process statement";
}
$sql = "SELECT * FROM complaints WHERE category = 'Abandonment'";
$stmt = $pdo->prepare($sql);
if ($stmt) {
    $stmt->execute([]);
    $abandonment = $stmt->rowCount();
} else {
    echo "Error: Unable to process statement";
}
$sql = "SELECT * FROM complaints WHERE category = 'Trafficking and Exploitation'";
$stmt = $pdo->prepare($sql);
if ($stmt) {
    $stmt->execute([]);
    $Trafficking = $stmt->rowCount();
} else {
    echo "Error: Unable to process statement";
}

$chartData = array(
    'labels' => array("Physical Abuse", "Sexual Abuse", "Child Labor", "Medical Neglect", "Abandonment", "Trafficking and Exploitation"),
    'series' => array('<?= $physical_abuse?>', '<?= $sexual_abuse ?>', '<?= $child_labor ?>', '<?= $medical_neglect ?>', '<?= $abandonment ?>', '<?= $trafficking ?>'),
);

header('Content-Type: application/json');
echo json_encode($chartData);
