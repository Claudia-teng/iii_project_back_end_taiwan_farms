<?php
$page_title = '資料列表';
$page_name = 'data-list';
require __DIR__. '/parts/__connect_db.php';


$sql = sprintf("SELECT * FROM `taiwan_farms` ORDER BY sid DESC");

$cate_id = isset($_GET['cate']) ? intval($_GET['cate']) : 0;

if($cate_id){
    $sql = sprintf("SELECT * FROM `taiwan_farms` WHERE `category_sid`= $cate_id");
}

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll();

//
$c_sql = "SELECT * FROM `taiwan_cities`";
$cates = $pdo->query($c_sql)->fetchAll();

?>




<?php require __DIR__. '/parts/__html_head.php'; ?>
<style>
table {
  border-collapse: collapse;
  margin: 100px auto 100px auto;
}

th {
    width: 20%;
}

.link {
    color: #83c5be;
}

.link:hover {
    text-decoration: none;
    color: #2a9d8f;

}

.button_group {
    width: 40%;
    margin: 40px auto;
}

.btn{
    background-color: #83c5be;
    color: white;
    margin: 20px 0px
}

</style>

<?php include __DIR__. '/parts/__navbar.php'; ?>

<div class="container">

    
    <div class="button_group">
    <a type="button" class="btn" href="data-list.php">全部</a>
    <?php foreach($cates as $c): ?>
        <a type="button" class="btn" href="?cate=<?= $c['sid'] ?>"><?= $c['city'] ?></a>
    <?php endforeach; ?>
    </div>
    

    <?php foreach($rows as $r): ?>
    <table class="table">
            <tr>
                <th>縣市</th>
                <td><?= $r['city'] ?></td>
            </tr>
            <tr>
                <th>農場名稱</th>
                <td><?= $r['farm'] ?></td>
            </tr>
            <tr>
                <th>日期</th>
                <td><?= $r['date'] ?></td>
            </tr>
            <tr>
                <th>價錢（每人）</th>
                <td><?= $r['price'] ?></td>
            </tr>
            <tr>
                <th>集合地點</th>
                <td><?= $r['departs'] ?></td>
            </tr>
            <tr>
                <th>地址</th>
                <td><?= $r['address'] ?></td>
            </tr>
            <tr>
                <th>活動簡介</th>
                <td><?= $r['introduction'] ?></td>
            </tr> 
            <tr>
            <tr>
                <th>照片</th>
                <td><img src="./../uploads/<?= $r['hash'] ?>" alt="" id="myimg" width="80%" class="text-align: center;"></td>
            </tr> 
            <tr>
                <th colspan="2"><a href="javascript: delete_it(<?= $r['sid'] ?>)" class="link d-flex justify-content-center">刪除活動</a></th>
            </tr>
            <tr>
                <th colspan="2"><a href="data-edit.php?sid=<?= $r['sid'] ?>" class="link d-flex justify-content-center">編輯活動</a></th>
            </tr>
                
    </table>
    <?php endforeach; ?>

</div>

<?php include __DIR__. '/parts/__scripts.php'; ?>
<script>

function delete_it(sid) {
    if (confirm(`確定要刪除嗎`)) {
        location.href='data-delete.php?sid=' + sid;;
    }
}


</script>
<?php include __DIR__. '/parts/__html_foot.php'; ?>
