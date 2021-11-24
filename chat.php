<?php
    session_start();
    if(!isset($_SESSION['idUser'])){
        header('location: index.php');
    }
    else{
        require_once('backend/mysql_config.php');
        $idUser = $_SESSION['idUser'];
        // get name user
        $query = "SELECT LastName, FirstName FROM users WHERE id = $idUser";
        $nameUserTable = getDataByQuery($query);
        $nameUser = $nameUserTable[0]['LastName'] . ' ' . $nameUserTable[0]['FirstName'];

        // get id_conversations participated
        $query = "SELECT Conversation_Id FROM participatants WHERE Users_Id = $idUser";
        $idConversations = getDataByQuery($query);
        $_SESSION['idConversations'] = $idConversations;

        // get id_users participated
        $paticipatantsInConversations = [];
        foreach($idConversations as $idConversation){
            $idCV = $idConversation['Conversation_Id'];
            $query = "SELECT Users_Id FROM participatants WHERE Conversation_Id = $idCV AND Users_Id != $idUser";
            $paticipatants = getDataByQuery($query);
            $paticipatantsInConversations[] = $paticipatants;
        }
    }
?>

<?php 
    require_once('./backend/web_config.php');
    load_top();
?>
<link rel="stylesheet" href="./frontend/chat.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <main>
         <section class='glass'>
             <div class="dashboard">
                 <img src="./frontend/img/user1.jpeg" alt="">
                 <h3><?php echo $nameUser; ?></h3>
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
                 <div class="chat-main">
                    <div class="list-conversation">
                        <div class="search-bar">
                            <i class="fas fa-search"></i>
                            <input placeholder="Tìm kiếm">
                        </div>
                        <div class="conversations">
                            <div class="conversations__title">
                                <span>Tất cả tin nhắn<i class="fas fa-chevron-down" style="margin-left: 5px;"></i></span>                               
                            </div>
                            <div class="conversations__main">                               
                                <?php
                                    $i = 0;
                                    foreach($paticipatantsInConversations as $paticipatants){
                                        // chat 1 vs 1
                                        if(count($paticipatants) == 1){
                                            $query = "SELECT LastName, FirstName FROM users WHERE id = {$paticipatants[0]['Users_Id']}";
                                            $name = getDataByQuery($query);
                                            $namePaticipatant = $name[0]['LastName'] . ' ' . $name[0]['FirstName'];
                                            $view = "
                                                <div class='conversation-item'>
                                                    <input name='idConversation' value='{$idConversations[$i]['Conversation_Id']}' style='display: none'>                                              
                                                    <img class='conversation-item__avatar' src='./frontend/img/user1.jpeg'>
                                                    <div class='conversation-item__content'>
                                                        <p class='title'>{$namePaticipatant}</p>
                                                        <p class='content'>Loading...</p>
                                                    </div>
                                                    <div class='conversation-item__time'>Loading...</div>
                                                </div>
                                                ";
                                            echo $view;
                                            $i++;
                                        }
                                        // chat group
                                        else{

                                        }                                        
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="chat-area">
                        <div class="chat-area__intro">
                            <p class="title">Chào mừng đến với <span style="font-weight: 500;">ChatApp!</span></p>
                            <p class="content">Khám phá ứng dụng trò chuyện trực tuyến với mọi người, kết bạn, giao lưu mọi nơi mọi lúc.</p>
                            <div class="slider-bar">
                                <div class="slider-bar__slides">
                                    <input id="slide-1" type="radio" name="slidebar" value="1" checked>
                                    <input id="slide-2" type="radio" name="slidebar" value="2">  
                                    <input id="slide-3" type="radio" name="slidebar" value="3">  
                                    <div class="slide">
                                        <img src="frontend/img/svg1.png">                                     
                                        <p class="title">Giao diện trực quan</p>
                                        <p class="content">Ứng dụng có giao diện trực quan, rất dễ sử dụng</p>                                   
                                    </div>  
                                    <div class="slide">
                                        <img src="frontend/img/svg2.png">                                     
                                        <p class="title">Trò chuyện thời gian thực</p>
                                        <p class="content">Trò chuyện trực tuyến, phản hồi tức thời</p>
                                    </div> 
                                    <div class="slide">
                                        <img src="frontend/img/svg3.png">                                     
                                        <p class="title">Gửi file nhanh chóng</p>
                                        <p class="content">Gửi file nặng, bất kì file nào, bất cứ lúc nào</p>
                                    </div>
                                    <div class="slider-bar__control0">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div> 
                                </div>
                                <div class="slider-bar__control">
                                    <label for="slide-1"></label>
                                    <label for="slide-2"></label>
                                    <label for="slide-3"></label>
                                </div>                                                                                      
                            </div>
                        </div>
                        <div class="chat-area__main" style="display: none;">
                            <div class="partner-info">
                                <div class="info">
                                    <img class="info__avatar" src="./frontend/img/user1.jpeg">
                                    <p class="info__status"><span></span></p>
                                    <div class="info__content">
                                        <p class="name">Mỹ Tâm</p>
                                        <p class="time">Online <span>5 phút</span> trước</p>
                                    </div>
                                </div>
                                <div class="tool-bar">
                                    <i class="fab fa-searchengin"></i>
                                    <i class="fas fa-video"></i>
                                    <i class="fas fa-teeth"></i>
                                </div>
                            </div>
                            <div class="area-message">
                                <!-- <div class="area-message__timer">
                                    <div class="side" style="margin-left: 65px;"></div>
                                    <div class="time">8:18&nbsp23/10/2021</div>
                                    <div class="side" style="margin-right: 65px;"></div>
                                </div>
                                <div class="area-message__message">
                                    <img class="avatar" src="./frontend/img/user1.jpeg">
                                    <div class="content">
                                        <p class="content__name">Mỹ Tâm</p>
                                        <p class="content__message">Xin chào tôi là phụ nữ</p>
                                        <p class="content__time">8:18</p>
                                    </div>
                                </div>
                                <div class="area-message__message" style="justify-content: flex-end; margin-right: 10px;">
                                    <img class="avatar" src="./frontend/img/user1.jpeg">
                                    <div class="content">
                                        <p class="content__name">Bạn</p>
                                        <p class="content__message">Xin chào tôi là đàn ông</p>
                                        <p class="content__time">09:40</p>
                                    </div>
                                </div>                                -->
                            </div>
                            <div class="area-send">
                                <div class="area-send__toolbar">
                                    <i class="far fa-image"></i>
                                    <i class="fas fa-paperclip"></i>
                                    <i class="fas fa-comment fast-menu">
                                        <div class="fast-menu__main">
                                            <p>Xin Chào</p>
                                            <p>Tạm biệt</p>
                                            <p>Hẹn gặp lại</p>
                                            <p>Hân hạnh làm quen</p>
                                        </div>
                                    </i>
                                </div>
                                <div class="area-send__input">
                                    <input type="text" placeholder="Gửi tin nhắn tới Mỹ Tâm" value="">
                                    <div class="symbol-bar">
                                        <i class="fas fa-greater-than" style="display: none;"></i>
                                        <i class="far fa-grin"></i>
                                        <i class="far fa-thumbs-up"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
             </div>
             <!-- <div id="Friends" class="tabcontent">
                <div class="friends-main">
                    <div class="list-conversation">
                        <i class="search-bar"></i>
                        <input placeholder="Tìm kiếm">
                    </div>
                </div>
             </div>
             <div id="Settings" class="tabcontent">
                 Cài đặt
             </div> -->
         </section>
    </main>

<!-- Circle -->
    <div class="circle1"></div>
    <div class="circle2"></div>

<script src="./frontend/chat.js"></script>
<!--Add Boostrap JS-->
<?php load_footer(); ?>