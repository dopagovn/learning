<?php
    session_start();
    if(!isset($_SESSION['idUser'])){
        header('location: index.php');
    }
    require './backend/web_config.php';
    load_top();
?>



<link rel="stylesheet" href="./frontend/chat.css">

    <main>
         <section class='glass'>
             <div class="dashboard">
                 <img src="./frontend/img/user1.jpeg" alt="">
                 <h3>Nguyễn Quốc Thịnh</h3>
                    <div class="links">
                        <span class="material-icons">
                            contact_page
                        </span>
                        <h2>Danh bạ</h2>
                    </div>
                    <div class="links">
                        <span class="material-icons">
                            contact_page
                        </span>
                        <h2>Danh bạ</h2>
                    </div>
                    <div class="links">
                        <span class="material-icons">
                            contact_page
                        </span>
                        <h2>Danh bạ</h2>
                    </div>
             </div>
             
             <div class="chat-box">
                 <h3>Chat BOX</h3>
             </div>
         </section>
    </main>
    <div class="circle1"></div>
    <div class="circle2"></div>
