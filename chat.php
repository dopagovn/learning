<?php 
    require_once('./backend/web_config.php');
    load_top();
?>


<link rel="stylesheet" href="./frontend/chat.css">

    <main>
         <section class='glass'>
             <div class="dashboard">
                 <img src="./frontend/img/user1.jpeg" alt="">
                 <h3>Bruce Wayne</h3>
                     <div class="links">
                        <a href="#" onclick="openTab( event , 'Chat')"><span class="material-icons">
                            chat_bubble
                        </span>
                        <h2>Tin nhắn</h2>
                        </a>
                    </div>
                    <div class="links">
                        <a href="#" onclick="openTab( event , 'Friends')"><span class="material-icons">
                            people
                        </span>
                        <h2>Bạn bè</h2>
                        </a>
                    </div>
                    <div class="links" onclick="openTab( event , 'Settings')">
                        <a href="#" ><span class="material-icons">
                            settings
                        </span>
                        <h2>Setting</h2>
                        </a>
                    </div>
                    <div class="logout">
                        <button><span class="material-icons">
                            logout
                        </span></button>
                    </div>
             </div>
             <!-- Tab Content -->
             <div id="Chat" class="tabcontent">
                 Tin nhắn
             </div>
             <div id="Friends" class="tabcontent">
                 Bạn bè
             </div>
             <div id="Settings" class="tabcontent">
                 Cài đặt
             </div>
         </section>
    </main>


    <div class="circle1"></div>
    <div class="circle2"></div>

<script src="./frontend/chat.js"></script>
<!--Add Boostrap JS-->
<?php load_footer(); ?>