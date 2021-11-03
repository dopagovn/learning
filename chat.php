<?php  session_start(); ?>

<?php
    require './backend/web_config.php';
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
                        <p>Chào em!</p>
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
            <div class="dashboard">
                    <img src="./frontend/img/user1.jpeg" alt="">
                    <div class="details">
                        <span>Người dùng 1</span>
                        <p>Đang hoạt động</p>
                    </div>
            </div>
            <div class="chat-box">
                <div class="chat outgoing">
                    <div class="details">
                        <p>Chào anh!</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="./frontend/img/user1.jpeg" alt="">
                    <div class="details">
                        <p>Chào em!</p>
                    </div>
                </div>
                <div class="chat outgoing">
                    <div class="details">
                        <p>Chào anh!</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="./frontend/img/user1.jpeg" alt="">
                    <div class="details">
                        <p>Chào em!</p>
                    </div>
                </div>
                <div class="chat outgoing">
                    <div class="details">
                        <p>Chào anh!</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="./frontend/img/user1.jpeg" alt="">
                    <div class="details">
                        <p>Chào em!</p>
                    </div>
                </div>
                <div class="chat outgoing">
                    <div class="details">
                        <p>Chào anh!</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="./frontend/img/user1.jpeg" alt="">
                    <div class="details">
                        <p>Chào em!</p>
                    </div>
                </div>
                <div class="chat outgoing">
                    <div class="details">
                        <p>Chào anh!</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="./frontend/img/user1.jpeg" alt="">
                    <div class="details">
                        <p>Chào em!</p>
                    </div>
                </div>
                <div class="chat outgoing">
                    <div class="details">
                        <p>Chào anh!</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="./frontend/img/user1.jpeg" alt="">
                    <div class="details">
                        <p>Chào em!</p>
                    </div>
                </div>
                <div class="chat outgoing">
                    <div class="details">
                        <p>Chào anh!</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="./frontend/img/user1.jpeg" alt="">
                    <div class="details">
                        <p>Chào em!</p>
                    </div>
                </div>
                <div class="chat outgoing">
                    <div class="details">
                        <p>Chào anh!</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="./frontend/img/user1.jpeg" alt="">
                    <div class="details">
                        <p>Chào em!</p>
                    </div>
                </div>
            </div>
            <form class="typing-area" action="#">
                <a href="#"><i class="material-icons">attach_file</i></a>
                <a href="#"><i class="material-icons">image</i></a>
                <input type="text" placeholder="Nhập tin nhắn tại đây...">
                <button class="btn"><i class="material-icons">send</i></button>
            </form>
        </div>
        <div class="block-right col">
            <h1><b>INFO</b></h1>
            <div class="details" align="center">
                <img src="./frontend/img/user1.jpeg" alt="">
                <a href="profile.php"><h2>Người dùng 1<h2></a>
            </div>
        </div>
    </div>
</div>

