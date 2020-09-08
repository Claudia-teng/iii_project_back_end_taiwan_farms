<?php
$page_title = '編輯活動';
$page_name = 'data-edit';
require __DIR__. '/parts/__connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

if(empty($sid)) {
    header('Location: data-list.php');
    exit;
}

$sql = "SELECT * FROM `taiwan_farms` WHERE sid = $sid";
$row = $pdo->query($sql)->fetch();

if (empty($row)) {
    header('Location: data-list.php');
    exit;
}

$c_sql = "SELECT * FROM `taiwan_cities` ORDER BY sid ASC";
$cates = $pdo->query($c_sql)->fetchAll();

?>

<?php require __DIR__. '/parts/__html_head.php'; ?>
<style>
.card {
    margin-top: 50px;
}
.btn {
    background-color: #83c5be;
}

.btn:hover {
    background-color: #2a9d8f;
}

#infobar {
    margin-top: 20px;
}
</style>
<?php include __DIR__. '/parts/__navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div id="infobar" class="alert alert-success" role="alert" style="display: none">
                A simple success alert—check it out!
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">編輯活動</h5>

                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                        <input type="hidden" name="sid" value="<?=$row['sid']?>">
                        <div class="form-group">
                            <label for="name">縣市</label>
                            <select class="form-control" id="city" name="city">
                                <?php foreach($cates as $c): ?>
                                    <option value="<?= $c['city'] ?>"<?= $row['category_sid']== $c['sid'] ? 'selected' : '' ?>><?= $c['city'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">農場名稱</label>
                            <input type="text" class="form-control" id="farm" name="farm" required
                            value="<?= htmlentities($row['farm']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="name">日期</label>
                            <input type="date" class="form-control" id="date" name="date" required
                            value="<?= htmlentities($row['date']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="name">價錢（每人）</label>
                            <input type="text" class="form-control" id="price" name="price" required
                            value="<?= htmlentities($row['price']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="name">集合地點</label>
                            <input type="text" class="form-control" id="departs" name="departs" required
                            value="<?= htmlentities($row['departs']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="name">地址</label>
                            <input type="text" class="form-control" id="address" name="address" required
                            value="<?= htmlentities($row['address']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="address">活動簡介</label>
                            <textarea class="form-control" id="introduction" name="introduction" cols="30" rows="5"
                            ><?= htmlentities($row['introduction']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="name">縣市分類代碼</label>
                            <input type="text" class="form-control" id="category_sid" name="category_sid" required
                            value="<?= htmlentities($row['category_sid']) ?>">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn"
                            onclick="file_input.click()">上傳照片</button>
                            <input type="hidden" id="myfile" name="myfile" value="<?= htmlentities($row['hash']) ?>"/>
                            <img src="./../uploads/<?= $row['hash'] ?>" alt="" id="myimg" width="250px">
                        </div>
                        <br><br>
                        <div class="form-group">
                            <button type="submit" class="btn">送出表單</button>
                        </div>
                    </form>
                    <input type="file" id="file_input" name="myfile" style="display: none">
                </div>
            </div>

        </div>
    </div>






</div>
<?php include __DIR__. '/parts/__scripts.php'; ?>
<script>
    const infobar = document.querySelector('#infobar');
    const file_input = document.querySelector('#file_input');
    const myfile = document.querySelector('#myfile');

    file_input.addEventListener('change', function (event) {
            console.log(file_input.files);
            const fd = new FormData(document.form1);
            fd.append('myfile', file_input.files[0]);

            fetch('image-api.php', {
                method: 'POST',
                body: fd
            })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    myfile.value = obj.filename;
                    document.querySelector('#myimg').src = './../uploads/' + obj.filename;

                });
    });



     function checkForm() {
        const fd2 = new FormData(document.form1);

        fetch('data-edit-api.php', {
                method: 'POST',
                body: fd2
            })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);

                    if(obj.success){
                    infobar.innerHTML = '編輯成功';
                    infobar.className = "alert alert-success";
                    setTimeout(() => {
                        location.href = '<?=$SERVER['HTTP_REFERER'] ?? "data-list.php" ?>'
                    }, 3000);
                } else {
                    infobar.innerHTML = obj.error || '編輯失敗';
                    infobar.className = "alert alert-danger";
                    submitBtn.style.display = 'block';
                }
                infobar.style.display = 'block';
                });

    }
</script>
<?php include __DIR__. '/parts/__html_foot.php'; ?>