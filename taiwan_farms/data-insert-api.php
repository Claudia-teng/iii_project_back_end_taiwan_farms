<?php
require __DIR__. '/parts/__connect_db.php';

header('Content-Type: application/json');
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];

$sql = "INSERT INTO `taiwan_farms` (
    `city`, `farm`, `date`,
    `price`, `departs`, `address`, `introduction`, `hash`, `category_sid`
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
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
]);
if ($stmt->rowCount()) {
    $output['success'] = true;
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
