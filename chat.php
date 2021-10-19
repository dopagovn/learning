<?php   
    require_once('./backend/web_config.php');
    load_top();
?>

<link rel="stylesheet" href="./frontend/chat.css">

<div class="container-fluid">
    <div class="row">
        <div class="block-left col">
            <h1>Messages</h1>

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
            <h1>Dashboard</h1>
        </div>
        <div class="block-right col">
            <h1>Thông tin</h1>
        </div>
    </div>
</div>


