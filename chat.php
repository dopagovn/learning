<?php   
    require_once('./backend/web_config.php');
    load_top();
?>

<link rel="stylesheet" href="./frontend/chat.css">

<div class="container-fluid">
    <div class="row">
        <div class="block-left col">
            <h1><b>MESSAGES</b></h1>

            <div class="input-icons">
                <i class="material-icons">search</i>
                <input id="search" type="text" placeholder="Tìm kiếm...">
            </div>
        
        <div class="user-list">
            <a href="#">
                <div class="content">
                    <img src="./frontend/img/user1.jpeg" alt="">
                    <div class="details">
                        <span>Người dùng 1</span>
                        <p>Đây là nội dung tin nhắn</p>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="content">
                    <img src="./frontend/img/user1.jpeg" alt="">
                    <div class="details">
                        <span>Người dùng 2</span>
                        <p>Đây là nội dung tin nhắn</p>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="content">
                    <img src="./frontend/img/user1.jpeg" alt="">
                    <div class="details">
                        <span>Người dùng 3</span>
                        <p>Đây là nội dung tin nhắn</p>
                    </div>
                </div>
            </a>
        </div>

        </div>
        <div class="block-center col-6">
            <h1><b>DASHBOARD</b></h1>
            <div class="dashboard">
                    <img src="./frontend/img/user1.jpeg" alt="">
                    <div class="details">
                        <span>Người dùng 1</span>
                        <p>Đang hoạt động</p>
                    </div>
            </div>
        </div>
        <div class="block-right col">
            <h1><b>INFO</b></h1>
            <div class="details" align="center">
                <img src="./frontend/img/user1.jpeg" alt="">
                <a href="#"><h2>Người dùng 1<h2></a>
            </div>
        </div>
    </div>
</div>

