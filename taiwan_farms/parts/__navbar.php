<?php
if(! isset($page_name)) $page_name = '';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">台灣小農地圖</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?= $page_name == 'data-list' ? 'active' : '' ?>">
                    <a class="nav-link" href="../taiwan_farms/data-list.php">體驗活動</a>
                </li>
                <li class="nav-item <?= $page_name == 'data-insert' ? 'active' : '' ?>">
                    <a class="nav-link" href="../taiwan_farms/data-insert.php">新增小農</a>
                </li>

            </ul>
        
           

        </div>
    </div>
</nav>
<style>
nav {
    position: fixed;
    top: 0px;
}

.navbar .nav-item.active {
    background-color: #83c5be;
    border-radius: 5px;
}

</style>