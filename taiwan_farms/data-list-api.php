<?php
require __DIR__. '/parts/__connect_db.php';
$path = __DIR__. '/../uploads/';

$output = [
    'cate' => 0,
    'rows' => [],
    'totalRows' => 0,
];

$t_sql = "SELECT COUNT(1) FROM `taiwan_farms`";
$output['totalRows'] = $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$rows = [];

if($totalRows > 0) {
    if(isset($_GET['cate'])) {
        $output['cate'] = $cate = ($_GET['cate']);
        $sql = sprintf("SELECT * FROM  `taiwan_farms` WHERE `category_sid` = $cate");
        $stmt = $pdo->query($sql);
        $output['rows'] = $rows = $stmt->fetchAll();
    } else {
        $sql = sprintf("SELECT * FROM `taiwan_farms` ORDER BY sid DESC");
        $stmt = $pdo->query($t_sql);
        $output['rows'] = $rows = $stmt->fetchAll();

    }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);