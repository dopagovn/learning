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

        // get avatar user
        $avatarUserDir = getAvatarById($idUser);

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
    ch_title("Dashboard");
?>

<link rel="stylesheet" href="./frontend/chat.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
<main>
    <section class='glass'>
        <div class="dashboard">
            <!-- avatar -->
            <img src="<?php echo $avatarUserDir; ?>" alt="">
            <h3>
                <?php echo $nameUser; ?>
            </h3>
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
            <div class="links">
                <a href="./profile.php"><span class="material-icons">
                        settings
                    </span>
                    <h2>Setting</h2>
                </a>
            </div>

            <div class="logout">
                <button onclick="window.location.href='./logout.php'"><span class="material-icons">
                        logout
                    </span></button>
            </div>
        </div>
        <!-- Tab Content -->
        <div id="Chat" class="tabcontent" style="display: block;">
            <div class="chat-main">
                <div class="list-conversation">
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input placeholder="Bạn bè">
                        <p class="close-search" title="Đóng tìm kiếm">Đóng</p>
                        <i class="fas fa-users group-menu" title="Tạo nhóm chat"></i>
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
                                            $namePaticipatant = getDataByQuery($query);
                                            $namePaticipatant = $namePaticipatant[0]['LastName'] . ' ' . $namePaticipatant[0]['FirstName'];
                                            $avatarPaticipant = getAvatarById($paticipatants[0]['Users_Id']);
                                            $view = "
                                                <div class='conversation-item'>
                                                    <input name='idConversation' value='{$idConversations[$i]['Conversation_Id']}' style='display: none'>                                              
                                                    <img class='conversation-item__avatar' src='{$avatarPaticipant}'>
                                                    <div class='conversation-item__content'>
                                                        <p class='title'>{$namePaticipatant}</p>
                                                        <p class='content'>Loading...</p>
                                                    </div>
                                                    <div class='conversation-item__time'>Loading...</div>
                                                </div>
                                                ";
                                            echo $view;
                                        }
                                        // chat group
                                        else{
                                            $query = "SELECT * FROM conversation WHERE Id = {$idConversations[$i]['Conversation_Id']}";
                                            $titleConversation = getDataByQuery($query);
                                            $titleConversation = $titleConversation[0]['Title'];
                                            $avatarPaticipant = '';
                                            $sumAvatar = 1;
                                            foreach($paticipatants as $paticipatant){   
                                                $avatarUrl = getAvatarById($paticipatant['Users_Id']);
                                                $avatarPaticipant .= "<img src='{$avatarUrl}'>";
                                                if($sumAvatar == 2){
                                                    break;
                                                }
                                                $sumAvatar++;
                                            }
                                            $viewTotal = '';
                                            if(count($paticipatants) == 3){
                                                $avatarUrl = getAvatarById($paticipatants[2]['Users_Id']);
                                                $avatarPaticipant .= "<img src='{$avatarUrl}'>";
                                            }
                                            else if(count($paticipatants) > 3){
                                                $avatarUrl = getAvatarById($paticipatants[2]['Users_Id']);
                                                $avatarPaticipant .= "<img src='{$avatarUrl}'>";
                                                $totalMember = count($paticipatants) + 1;
                                                $viewTotal = "
                                                    <div class='total-member'>
                                                        <p>{$totalMember}</p>
                                                    </div>
                                                ";
                                            }

                                            $view = "
                                                <div class='conversation-item'>
                                                    <input name='idConversation' value='{$idConversations[$i]['Conversation_Id']}' style='display: none'>                                              
                                                    <div class='conversation-item__avatar-group'>
                                                        {$avatarPaticipant}
                                                        {$viewTotal}
                                                    </div>
                                                    <div class='conversation-item__content'>
                                                        <p class='title'>{$titleConversation}</p>
                                                        <p class='content'>Loading...</p>
                                                    </div>
                                                    <div class='conversation-item__time'>Loading...</div>
                                                </div>
                                            ";
                                            echo $view;
                                        }
                                        $i++;                                        
                                    }
                                ?>
                        </div>
                    </div>
                    <div class="search-bar__result"></div>
                </div>
                <div class="chat-area">
                    <div class="chat-area__intro">
                        <p class="title">Chào mừng đến với <span style="font-weight: 500;">ChatApp!</span></p>
                        <p class="content">Khám phá ứng dụng trò chuyện trực tuyến với mọi người, kết bạn, giao lưu mọi
                            nơi mọi lúc.</p>
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
                                <div></div>
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
                                    <div class="tool">
                                        <div class="tool__btn">
                                            <i class="fas fa-ellipsis-v btn-more"></i>
                                        </div>
                                        <div class="tool__menu" style="display: none;">
                                            <p class="btn-delete">Xóa, gỡ bỏ</p>
                                            <i class="fas fa-caret-down"></i>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <p class="content__name">Bạn</p>
                                        <p class="content__message">Xin chào tôi là đàn ông</p>
                                        <p class="content__time">09:40</p>
                                    </div>
                                </div>
                                <div class="area-message__message" style="justify-content: flex-end; margin-right: 10px;">
                                    <div class="content">
                                        <p class="content__name">Bạn</p>
                                        <img class="content__img" src="frontend/img/like-icon.gif"
                                            style="width: 50px;">
                                        <p class="content__time">09:40</p>
                                    </div>
                                </div>
                                <div class="area-message__viewImage" style="display: none;">                               
                                    <img class="content__img" src="backend/message_file/56504108_1_5_Untitled123.png">
                                    <i class="fas fa-times"></i>
                                </div> -->
                        </div>
                        <div class="area-send">
                            <div class="area-send__toolbar">
                                <i class="far fa-image send-img"></i>
                                <i class="fas fa-paperclip send-file"></i>
                                <i class="fas fa-comment fast-menu">
                                    <div class="fast-menu__main">
                                        <p>Xin Chào</p>
                                        <p>Tạm biệt</p>
                                        <p>Hẹn gặp lại</p>
                                        <p>Hân hạnh làm quen</p>
                                    </div>
                                </i>
                            </div>
                            <div class="area-send__fileView">
                            </div>
                            <div class="area-send__input">
                                <input class="area-send__input-image" type="file" style="display: none;"
                                    accept="image/*">
                                <input class="area-send__input-file" type="file" style="display: none;">
                                <input class="area-send__input-text" type="text" placeholder="Gửi tin nhắn tới Mỹ Tâm"
                                    value="">
                                <div class="symbol-bar">
                                    <i class="fas fa-greater-than" style="display: none;"></i>
                                    <i class="far fa-grin send-icon">
                                        <div class="send-icon__menu">
                                            <?php
                                                    $src = "backend/icon/";
                                                    for($i = 1; ; $i++){
                                                        $name = $i . "Icon.gif";
                                                        if(file_exists($src . $name)){
                                                            echo "<img src='backend/icon/{$i}Icon.gif'>";
                                                        }
                                                        else{
                                                            break;
                                                        }
                                                    }
                                                ?>
                                        </div>
                                    </i>
                                    <i class="far fa-thumbs-up send-like"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="group-create__form" style="display: none;">
                <form method="POST" action="group.php">
                    <div class="title">
                        <p>Tạo nhóm</p>
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="info">
                        <input type="text" name="nameGroup" value="" placeholder="Nhập tên nhóm">
                    </div>
                    <div class="add-people">
                        <p>Thêm bạn vào nhóm</p>
                        <input type="text" placeholder="Nhập tên, email, hoặc số điện thoại">
                        <p>Tất cả</p>
                    </div>
                    <div class="list-friend">
                        <?php
                            if(isset($_GET['errorCreateGroup'])){
                                echo "
                                    <script>
                                        var check = alert('Hãy chọn ít nhất 2 thành viên');
                                    </script>
                                "; 
                            }
                        ?>
                        <!-- <div class="list-friend__row">
                            <input type="checkbox" value="">
                            <img class="avatar" src="backend/avatar/1.png">
                            <span>Batman</span>
                        </div> -->
                    </div>
                    <div class="btns">
                        <p>Hủy</p>
                        <input class="disable" type="submit" name="createGroup" value="Tạo nhóm">
                    </div>
                </form>
            </div>
        </div>
        <!-- Friends tabs -->
        <div id="Friends" class="tabcontent" style="display: none;">
            <div class="friend-main">
                <div class="list-conversation">
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input id="input-data" placeholder="Tìm kiếm">
                    </div>
                    <div class="conversations">
                        <div class="contact-list-item">
                            <img src="./frontend/img/list-user-add.png" class="fr-conv-item-avt">
                            <p>Danh sách kết bạn</p>
                        </div>
                        <div class="contact-list-item">
                            <img src="./frontend/img/group-list.png" class="fr-conv-item-avt">
                            <p>Danh sách nhóm</p>
                        </div>
                        <div class="conversations__title">
                            <span>Danh sách bạn bè<i class="fas fa-chevron-down" style="margin-left: 5px;"></i></span>
                        </div>
                        <div class="conversations__main">

                        </div>
                    </div>
                </div>
                <div class="search-filter">
                    <div class="content">
                        <h2>Tìm kiếm</h2>
                        <div class="main-filter">


                            <?php 
                                    $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
                                    $sql = "SELECT * FROM users";
                                    $query = mysqli_query($connect, $sql);
                                    $num = mysqli_num_rows($query);
                                    if($num > 0){
                                        while($row = mysqli_fetch_array($query)){

                                            if($row['Gender'] == 1)
                                                $row['Gender'] = "Nam";
                                                else{
                                                    $row['Gender'] = "Nữ";
                                                }    
                                ?>


                            <?php 
                                    }
                                }
                                ?>
                            Loading...
                        </div>

                    </div>
                </div>
            </div>


    </section>
</main>


<!-- Circle -->
<div class="circle1"></div>
<div class="circle2"></div>

<script src="./frontend/chat.js"></script>
<script src="./frontend/friends.js"></script>

<!--Add Boostrap JS-->
<?php load_footer(); ?>