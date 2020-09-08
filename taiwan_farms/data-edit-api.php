<?php
require __DIR__ . '/parts/__connect_db.php';

header('Content-Type: application/json');

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];

$sql = "UPDATE `taiwan_farms` SET
`city` = ?,
`farm` = ?,
`date` = ?,
`price` = ?,
`departs` = ?,
`address` = ?,
`introduction` = ?,
`hash` = ?,
`category_sid` = ?
WHERE `sid` = ?";


$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['city'],
    $_POST['farm'],
    $_POST['date'],
    $_POST['price'],
    $_POST['departs'],
    $_POST['address'],
    $_POST['introduction'],
    $_POST['myfile'],
    $_POST['category_sid'],
    $_POST['sid'],
]);


if ($stmt->rowCount()) {
    $output['success'] = true;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);