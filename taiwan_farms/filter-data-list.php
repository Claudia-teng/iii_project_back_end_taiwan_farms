<?php
$page_title = '資料列表';
$page_name = 'data-list';
require __DIR__. '/parts/__connect_db.php';


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
        $stmt = $pdo->query($sql);
        $output['rows'] = $rows = $stmt->fetchAll();

    }
}

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

.active{
    color: red;
}
.cate {
    margin: 20px;
}

</style>

<?php include __DIR__. '/parts/__navbar.php'; ?>

<div class="container">
    <div class="cities"></div>

    <div class="table_list"><div>

</div>

<?php include __DIR__. '/parts/__scripts.php'; ?>
<script>

function delete_it(sid) {
    if (confirm(`確定要刪除嗎`)) {
        location.href='data-delete.php?sid=' + sid;
    }
}



const hashHandler = function() {

let h = parseInt(location.hash.slice(1)) || 1;
console.log('h', h);
getData(h);
}

window.addEventListener('hashchange', hashHandler);

hashHandler();

const cateItemTpl = (o) => {
    return `<a class="cate ${o.active}" href="#${o.cate}">${o.cate}</a>`
}

const tableRowTpl = (i) => {
    return `
    <table class="table">
            <tr>
                <th>縣市</th>
                <td>${i.city}</td>
            </tr>
            <tr>
                <th>農場名稱</th>
                <td>${i.farm}</td>
            </tr>
            <tr>
                <th>日期</th>
                <td>${i.date}</td>
            </tr>
            <tr>
                <th>價錢（每人）</th>
                <td>${i.price}</td>
            </tr>
            <tr>
                <th>集合地點</th>
                <td>${i.departs}</td>
            </tr>
            <tr>
                <th>地址</th>
                <td>${i.address}</td>
            </tr>
            <tr>
                <th>活動簡介</th>
                <td>${i.introduction}</td>
            </tr> 
            <tr>
            <tr>
                <th colspan="2"><a href="javascript: delete_it(${i.sid})" class="link d-flex justify-content-center">刪除活動</a></th>
            </tr>
            <tr>
                <th colspan="2"><a href="data-edit.php?sid=${i.sid}" class="link d-flex justify-content-center">編輯活動</a></th>
            </tr>
                
    </table>
    `
}

function getData (cate) {
    fetch('filter-data-list-api.php?cate=' + cate)
    .then(r => r.json())
    .then(obj => {
        console.log('obj', obj);

        let str = '';
        for(let i of obj.rows) {
            str += tableRowTpl(i)
        }
        document.getElementsByClassName('table_list')[0].innerHTML = str;

        str = '';

        for(let i = 1; i < 18; i++) {

            const o = {cate: i, active: ''}

            if(obj.cate === i) {
                o.active = 'active';
            }
            
            str += cateItemTpl(o); 
        }
        document.getElementsByClassName('cities')[0].innerHTML = str;

    });
}

</script>
<?php include __DIR__. '/parts/__html_foot.php'; ?>
