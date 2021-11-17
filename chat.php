<?php 
    require_once('./backend/web_config.php');
    load_top();
?>

<?php
    session_start();
    if(!isset($_SESSION["idUser"]))

        header("location:index.php");
?>


<link rel="stylesheet" href="./frontend/chat.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
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
             <!-- Chat Tabs -->
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
                                <div class="conversation-item">
                                    <img class="conversation-item__avatar" src="./frontend/img/user1.jpeg">
                                    <div class="conversation-item__content">
                                        <p class="title">Nguyễn Văn</p>
                                        <p class="content">Batman: Xin chào thế giới I am hero</p>
                                    </div>
                                    <div class="conversation-item__time">23 giờ</div>
                                </div>
                                <div class="conversation-item">
                                    <img class="conversation-item__avatar" src="./frontend/img/user1.jpeg">
                                    <div class="conversation-item__content">
                                        <p class="title">Trần Huy</p>
                                        <p class="content">SS7: Xin chào thế giới I am hero</p>
                                    </div>
                                    <div class="conversation-item__time">2 ngày</div>
                                </div>
                                <div class="conversation-item">
                                    <img class="conversation-item__avatar" src="./frontend/img/user1.jpeg">
                                    <div class="conversation-item__content">
                                        <p class="title">Mỹ Tâm</p>
                                        <p class="content">SS2: Xin chào thế giới I am hero</p>
                                    </div>
                                    <div class="conversation-item__time">3 giờ</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-area">
                        <!-- <div class="chat-area__intro">
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
                        </div> -->
                        <div class="chat-area__main">
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
                                <div class="area-message__timer">
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
                                <div class="area-message__message">
                                    <img class="avatar" src="./frontend/img/user1.jpeg">
                                    <div class="content">
                                        <p class="content__name">Bạn</p>
                                        <p class="content__message">Xin chào tôi là đàn ông</p>
                                        <p class="content__time">09:40</p>
                                    </div>
                                </div>
                                <div class="area-message__message">
                                    <img class="avatar" src="./frontend/img/user1.jpeg">
                                    <div class="content">
                                        <p class="content__name">Mỹ Tâm</p>
                                        <p class="content__message">Bạn bao nhiêu tuổi?</p>
                                        <p class="content__time">13:42</p>
                                    </div>
                                </div>
                                <div class="area-message__timer">
                                    <div class="side" style="margin-left: 65px;"></div>
                                    <div class="time">07:18&nbsp24/10/2021</div>
                                    <div class="side" style="margin-right: 65px;"></div>
                                </div>
                                <div class="area-message__message">
                                    <img class="avatar" src="./frontend/img/user1.jpeg">
                                    <div class="content">
                                        <p class="content__name">Bạn</p>
                                        <p class="content__message">Mình 16 tuổi, còn bạn?</p>
                                        <p class="content__time">07:18</p>
                                    </div>
                                </div>
                                <div class="area-message__timer">
                                    <div class="side" style="margin-left: 65px;"></div>
                                    <div class="time">13:48&nbsp25/10/2021</div>
                                    <div class="side" style="margin-right: 65px;"></div>
                                </div>
                                <div class="area-message__message">
                                    <img class="avatar" src="./frontend/img/user1.jpeg">
                                    <div class="content">
                                        <p class="content__name">Mỹ Tâm</p>
                                        <p class="content__message">Mình 18 tuổi</p>
                                        <p class="content__time">13:48</p>
                                    </div>
                                </div>
                                <div class="area-message__message">
                                    <img class="avatar" src="./frontend/img/user1.jpeg">
                                    <div class="content">
                                        <p class="content__name">Mỹ Tâm</p>
                                        <p class="content__message">Bạn làm nghề gì?</p>
                                        <p class="content__time">14:02</p>
                                    </div>
                                </div>
                                <div class="area-message__message">
                                    <img class="avatar" src="./frontend/img/user1.jpeg">
                                    <div class="content">
                                        <p class="content__name">Bạn</p>
                                        <p class="content__message">I am hero</p>
                                        <p class="content__time">16:07</p>
                                    </div>
                                </div>
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
                                        <i class="far fa-grin"></i>
                                        <i class="far fa-thumbs-up"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
             </div>
            <!-- Friends tabs --> 
             <div id="Friends" class="tabcontent">
                 <div class="friend-main">
                    <div class="list-conversation">
                        <div class="search-bar">
                            <i class="fas fa-search"></i>
                            <input placeholder="Tìm kiếm">
                        </div>
                        <div class="conversations">
                             <div class="contact-list-item">
                                    <img src="./frontend/img/list-user-add.png" class="fr-conv-item-avt">
                                    <p>Danh sách kết bạn</p>
                                </div>
                            <div class="conversations__title">
                                <span>Danh sách bạn bè (3)<i class="fas fa-chevron-down" style="margin-left: 5px;"></i></span>                               
                            </div>
                            <div class="conversations__main">
                                <div class="conversation-item">
                                    <img class="conversation-item__avatar" src="./frontend/img/user1.jpeg">
                                    <div class="conversation-item__content">
                                        <p class="title">Nguyễn Văn</p>
                                    </div>
                                </div>
                                <div class="conversation-item">
                                    <img class="conversation-item__avatar" src="./frontend/img/user1.jpeg">
                                    <div class="conversation-item__content">
                                        <p class="title">Trần Huy</p>
                                    </div>
                                </div>
                                <div class="conversation-item">
                                    <img class="conversation-item__avatar" src="./frontend/img/user1.jpeg">
                                    <div class="conversation-item__content">
                                        <p class="title">Mỹ Tâm</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="friend-add__list">
                    <img src="./frontend/img/list-user-add.png" class="fr-conv-item-avt">
                    <h4 class="tab-name">Danh sách kết bạn</h4>

                    <div class="area-add">
                        <div class="card-item" style="width: 16rem;">
                            <div class="card-item__content">
                                <img src="./frontend/img/user1.jpeg" class="card-img-top rounded-3" alt="...">
                                <div class="card-item__body">
                                    <h6 class="card-title">Batman</h6>
                                    <a href="#" class="btn btn-primary">Đồng ý</a>
                                    <a href="#"class="btn btn-outline-primary">Hủy</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-item" style="width: 16rem;">
                            <div class="card-item__content">
                                <img src="./frontend/img/user3.jpg" class="card-img-top rounded-3" alt="...">
                                <div class="card-item__body">
                                    <h6 class="card-title">Wonder Woman</h6>
                                    <a href="#" class="btn btn-primary">Đồng ý</a>
                                    <a href="#"class="btn btn-outline-primary">Hủy</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
             </div>

             <!-- Settings tabs 
             <div id="Settings" class="tabcontent">
                 Cài đặt
             </div>
             --> 
         </section>
    </main>

<!-- Circle -->
    <div class="circle1"></div>
    <div class="circle2"></div>

<script src="./frontend/chat.js"></script>
<!--Add Boostrap JS-->
<?php load_footer(); ?>