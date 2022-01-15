<?php 
    //tool
    function compareDate($date1, $date2){   
        if($date2->format('y') > $date1->format('y')){
            return true;
        }
        if($date2->format('m') > $date1->format('m')){
            return true;
        }
        if($date2->format('d') > $date1->format('d')){
            return true;
        }
        return false;
    }
?>
<?php 
    session_start();
    if(!isset($_SESSION['idUser'])){
        header('location: index.php');
    }
    // reload messages
    else if(isset($_POST['ReloadMessages'])){
        if(isset($_SESSION['idConversations'])){
            require_once('backend/mysql_config.php');

            $idUser = $_SESSION['idUser'];
            $idConversations = $_SESSION['idConversations'];
            $messages = [];
            // get all messages of Conversations
            foreach($idConversations as $idConversation){
                $query = "SELECT * FROM messages WHERE Conversation_Id = {$idConversation['Conversation_Id']}";
                $messages[] = getDataByQuery($query);    
            }

            $view = [];
            foreach($messages as $message){
                $contentMessage = "";

                $previousDay = null;
                foreach($message as $mes){
                    $time = $mes['Create_at'];
                    // add timer
                    if(!isset($previousDay)){
                        $date = new DateTime($time);
                        $viewDate = $date->format('d') . '/' . $date->format('m') . '/' . $date->format('Y');       
                        $contentMessage .= "             
                                <div class='area-message__timer'>
                                    <div class='side' style='margin-left: 65px;'></div>
                                    <div class='time'>{$date->format('H')}:{$date->format('i')}&nbsp{$viewDate}</div>
                                    <div class='side' style='margin-right: 65px;'></div>
                                </div>
                            ";
                    }
                    else{
                        if(compareDate($previousDay, new DateTime($time))){
                            $date = new DateTime($time);
                            $viewDate = $date->format('d') . '/' . $date->format('m') . '/' . $date->format('Y');       
                            $contentMessage .= "             
                                    <div class='area-message__timer'>
                                        <div class='side' style='margin-left: 65px;'></div>
                                        <div class='time'>{$date->format('H')}:{$date->format('i')}&nbsp{$viewDate}</div>
                                        <div class='side' style='margin-right: 65px;'></div>
                                    </div>
                                ";
                        }
                    }
                    $previousDay = new DateTime($time);

                    // messages
                    $time = explode(' ', $time);
                    $time = explode(':' ,$time[1]);
                    $time = $time[0] . ':' . $time[1];
                    if($mes['Sender_Id'] == $idUser){
                        // is user
                        if($mes['Delete_at'] != NULL){
                            // message be deleted
                            $timeDelete = $mes['Delete_at'];
                            $timeDelete = explode(' ', $timeDelete);
                            $timeDelete = explode(':' ,$timeDelete[1]);
                            $timeDelete = $timeDelete[0] . ':' . $timeDelete[1];
                            $contentMessage .= "
                                <div class='area-message__message' style='justify-content: flex-end; margin-right: 10px;'>
                                    <div class='content'>
                                        <p class='content__name'>Bạn</p>
                                        <p class='content__message content__message--delete'>Tin nhắn đã bị xóa</p>
                                        <p class='content__time'  style='display: none;'>{$timeDelete}</p>
                                    </div>
                                </div>
                            ";
                        }
                        else if($mes['Message_Type'] == 'text'){
                            $contentMessage .= "
                                <div class='area-message__message' style='justify-content: flex-end; margin-right: 10px;'>
                                    <div class='tool'>
                                        <div class='tool__btn'>
                                            <i class='fas fa-ellipsis-v btn-more'></i>
                                        </div>
                                        <div class='tool__menu' style='display: none;'>
                                            <p class='btn-delete'>Xóa, gỡ bỏ</p>
                                            <input value='{$mes['Id']}' style='display: none;'>
                                            <i class='fas fa-caret-down'></i>
                                        </div>
                                    </div>
                                    <div class='content'>
                                        <p class='content__name'>Bạn</p>
                                        <p class='content__message'>{$mes['Message']}</p>
                                        <p class='content__time'>{$time}</p>
                                    </div>
                                </div>
                            ";
                        }
                        else{
                            // is file
                            $file_urls = explode(',', $mes['Attachment_url']);
                            foreach($file_urls as $url){
                                $ext = explode('.', $url);
                                $ext = $ext[count($ext) - 1];
                                if(strcasecmp($ext,'png') == 0 || strcasecmp($ext,'jpg') == 0 || strcasecmp($ext,'jpge') == 0 || strcasecmp($ext,'ico') == 0 || strcasecmp($ext,'gif') == 0){
                                    $contentMessage .= "
                                        <div class='area-message__message' style='justify-content: flex-end; margin-right: 10px;'>
                                            <div class='tool'>
                                                <div class='tool__btn'>
                                                    <i class='fas fa-ellipsis-v btn-more'></i>
                                                </div>
                                                <div class='tool__menu' style='display: none;'>
                                                    <p class='btn-delete'>Xóa, gỡ bỏ</p>
                                                    <input value='{$mes['Id']}' style='display: none;'>
                                                    <i class='fas fa-caret-down'></i>
                                                </div>
                                            </div>
                                            <div class='content'>
                                                <p class='content__name'>Bạn</p>
                                                <img class='content__img' src='{$url}'>
                                                <p class='content__time'>{$time}</p>
                                            </div>
                                        </div>
                                    ";
                                }
                                else{
                                    // is other file
                                    $icon;
                                    if(strcasecmp($ext,'doc') == 0 || strcasecmp($ext,'.docx') == 0){
                                        $icon = "<img src='frontend/img/iconWORD.png'>";
                                    }
                                    else if(strcasecmp($ext,'pdf') == 0){
                                        $icon = "<img src='frontend/img/iconPDF.png'>";
                                    }
                                    else if(strcasecmp($ext,'txt') == 0){
                                        $icon = "<img src='frontend/img/iconTXT.png'>";
                                    }
                                    else if(strcasecmp($ext,'zip') == 0 || strcasecmp($ext,'rar') == 0){
                                        $icon = "<img src='frontend/img/iconZIP.png'>";
                                    }
                                    else if(strcasecmp($ext,'css') == 0){
                                        $icon = "<img src='frontend/img/iconCSS.png'>";
                                    }
                                    else{
                                        $icon = "<img src='frontend/img/iconGeneral.png'>";
                                    }
                                    $nameFile = explode('_', $url);
                                    $nameFile = $nameFile[count($nameFile) - 1];
                                    require_once('backend/tool_file.php');
                                    $sizeFile = filesize($url);
                                    $sizeFile = byteTo($sizeFile);

                                    $contentMessage .= "
                                        <div class='area-message__message' style='justify-content: flex-end; margin-right: 10px;'>
                                            <div class='tool'>
                                                <div class='tool__btn'>
                                                    <i class='fas fa-ellipsis-v btn-more'></i>
                                                </div>
                                                <div class='tool__menu' style='display: none;'>
                                                    <p class='btn-delete'>Xóa, gỡ bỏ</p>
                                                    <input value='{$mes['Id']}' style='display: none;'>
                                                    <i class='fas fa-caret-down'></i>
                                                </div>
                                            </div>
                                            <div class='content'>
                                                <p class='content__name'>Bạn</p>
                                                <div class='content__download'>
                                                    $icon
                                                    <div class='content__download-name'>
                                                        <p>$nameFile</p>
                                                        <p>{$sizeFile}</p>
                                                    </div>
                                                    <a href='{$url}' download='{$nameFile}'><i class='far fa-arrow-alt-circle-down'></i></a>
                                                </div>
                                                <p class='content__time'>{$time}</p>
                                            </div>
                                            
                                        </div>
                                    ";
                                }
                            }
                        }                
                    }
                    else{
                        // is other user
                        $namePaticipatant = getDataByQuery("SELECT LastName, FirstName FROM users WHERE id = {$mes['Sender_Id']}");
                        $namePaticipatant = $namePaticipatant[0]['LastName'] . ' ' . $namePaticipatant[0]['FirstName'];
                        $avatarUrl = 'frontend/img/avatar-default-icon.png';
                        require_once('backend/tool_file.php');
                        $ext;
                        if(testImageExist('backend/avatar/' . $mes['Sender_Id'], $ext)){
                            $avatarUrl = 'backend/avatar/' . $mes['Sender_Id'] . '.' . $ext;
                        }

                        if($mes['Delete_at'] != NULL){
                            // message be deleted
                            $timeDelete = $mes['Delete_at'];
                            $timeDelete = explode(' ', $timeDelete);
                            $timeDelete = explode(':' ,$timeDelete[1]);
                            $timeDelete = $timeDelete[0] . ':' . $timeDelete[1];
                            $contentMessage .= "
                                <div class='area-message__message'>
                                    <img class='avatar' src='{$avatarUrl}'>
                                    <div class='content'>
                                        <p class='content__name'>{$namePaticipatant}</p>
                                        <p class='content__message content__message--delete'>Tin nhắn đã bị xóa</p>
                                        <p class='content__time' style='display: none;'>{$timeDelete}</p>
                                    </div>
                                </div>
                            ";
                        }
                        else if($mes['Message_Type'] == 'text'){
                            $contentMessage .= "
                                <div class='area-message__message'>
                                    <img class='avatar' src='{$avatarUrl}'>
                                    <div class='content'>
                                        <p class='content__name'>{$namePaticipatant}</p>
                                        <p class='content__message'>{$mes['Message']}</p>
                                        <p class='content__time'>{$time}</p>
                                    </div>
                                </div>
                            ";
                        }
                        else{
                            // is file
                            $file_urls = explode(',', $mes['Attachment_url']);
                            foreach($file_urls as $url){
                                $ext = explode('.', $url);
                                $ext = $ext[count($ext) - 1];
                                if(strcasecmp($ext,'png') == 0 || strcasecmp($ext,'jpg') == 0 || strcasecmp($ext,'jpge') == 0 || strcasecmp($ext,'ico') == 0 || strcasecmp($ext,'gif') == 0){
                                    $contentMessage .= "
                                        <div class='area-message__message'>
                                            <img class='avatar' src='{$avatarUrl}'>
                                            <div class='content'>
                                                <p class='content__name'>{$namePaticipatant}</p>
                                                <img class='content__img' src='{$url}'>
                                                <p class='content__time'>{$time}</p>
                                            </div>
                                        </div>
                                    ";
                                }
                                else{
                                    // is other file
                                    $icon;
                                    if(strcasecmp($ext,'doc') == 0 || strcasecmp($ext,'.docx') == 0){
                                        $icon = "<img src='frontend/img/iconWORD.png'>";
                                    }
                                    else if(strcasecmp($ext,'pdf') == 0){
                                        $icon = "<img src='frontend/img/iconPDF.png'>";
                                    }
                                    else if(strcasecmp($ext,'txt') == 0){
                                        $icon = "<img src='frontend/img/iconTXT.png'>";
                                    }
                                    else if(strcasecmp($ext,'zip') == 0 || strcasecmp($ext,'rar') == 0){
                                        $icon = "<img src='frontend/img/iconZIP.png'>";
                                    }
                                    else if(strcasecmp($ext,'css') == 0){
                                        $icon = "<img src='frontend/img/iconCSS.png'>";
                                    }
                                    else{
                                        $icon = "<img src='frontend/img/iconGeneral.png'>";
                                    }
                                    $nameFile = explode('_', $url);
                                    $nameFile = $nameFile[count($nameFile) - 1];
                                    require_once('backend/tool_file.php');
                                    $sizeFile = filesize($url);
                                    $sizeFile = byteTo($sizeFile);

                                    $contentMessage .= "
                                        <div class='area-message__message'>
                                            <img class='avatar' src='{$avatarUrl}'>
                                            <div class='content'>
                                                <p class='content__name'>{$namePaticipatant}</p>
                                                <div class='content__download'>
                                                    $icon
                                                    <div class='content__download-name'>
                                                        <p>$nameFile</p>
                                                        <p>{$sizeFile}</p>
                                                    </div>
                                                    <a href='{$url}' download='{$nameFile}'><i class='far fa-arrow-alt-circle-down'></i></a>
                                                </div>
                                                <p class='content__time'>{$time}</p>
                                            </div>
                                        </div>
                                    ";
                                }
                            }
                        }
                    }                  
                }
                $view[] = $contentMessage;
            }
            $json = json_encode($view);
            echo $json;
        }       
    }
    else if(isset($_POST['ChooseConversation'])){
        $_SESSION['ConversationChosen'] = $_POST['ChooseConversation'];
    }

    if(isset($_POST['sendMessage'])){
        require_once('backend/mysql_config.php');
        if(!empty($_POST['sendMessage']) && isset($_SESSION['ConversationChosen'])){
            $contentMessage = $_POST['sendMessage'];
            $currentIdConversation = $_SESSION['ConversationChosen'];
            $query = "INSERT INTO messages(Conversation_Id, Sender_Id, Message_Type, Message, Attachment_url, Create_at)
                VALUES ({$currentIdConversation}, {$_SESSION['idUser']}, 'text', N'{$contentMessage}', NULL, CURRENT_TIMESTAMP)
            ";
            excuteQuery($query);
        }
        $files = [];
        for($i = 0; ; $i++){
            if(isset($_FILES['sendFile' . $i])){
                $files[] = $_FILES['sendFile' . $i];
            }
            else{
                break;
            }
        }
        // insert file to sql
        if(count($files) > 0){
            $currentIdConversation = $_SESSION['ConversationChosen'];
            $attachmentUrls = [];
            for($i = 0; $i < count($files); $i++){
                $tmp_name = $files[$i]['tmp_name'];
                $file_name = $files[$i]['name'];
                $file_name = rand() . '_' . $currentIdConversation . '_' . $_SESSION['idUser'] . '_' .$file_name;
                $dir = 'backend/message_file/' . $file_name;
                move_uploaded_file($tmp_name, $dir);
                $attachmentUrls[] = $dir;
            }
            $attachmentUrls = implode(',', $attachmentUrls);
            // insert
            $query = "INSERT INTO messages(Conversation_Id, Sender_Id, Message_Type, Message, Attachment_url, Create_at)
                VALUES ({$currentIdConversation}, {$_SESSION['idUser']}, 'file', NULL, '{$attachmentUrls}', CURRENT_TIMESTAMP)
            ";
            excuteQuery($query);
        }
    }
    
    if(isset($_POST['deleteMessage'])){
        require_once('backend/mysql_config.php');
        $query = "UPDATE messages SET Delete_at = CURRENT_TIMESTAMP WHERE id = {$_POST['deleteMessage']}";
        excuteQuery($query);
        echo 'delete ' . $_POST['deleteMessage'];
    }
    if(isset($_POST['sendIcon'])){
        require_once('backend/mysql_config.php');
        $currentIdConversation = $_SESSION['ConversationChosen'];
        $url = 'backend/icon/' . $_POST['sendIcon'];
        if(!file_exists($url)){
            echo 'icon does not exist';
            exit();
        }
        $query = "INSERT INTO messages(Conversation_Id, Sender_Id, Message_Type, Message, Attachment_url, Create_at)
            VALUES ({$currentIdConversation}, {$_SESSION['idUser']}, 'file', NULL, '{$url}', CURRENT_TIMESTAMP)
        ";
        excuteQuery($query);
        echo 'send icon';
    }
    if(isset($_POST['createConversation'])){
        require_once('backend/mysql_config.php');
        $idFriend = $_POST['createConversation'];
        $query = "SELECT Conversation_Id FROM participatants WHERE (Users_Id = {$_SESSION['idUser']} OR Users_Id = {$idFriend}) GROUP BY Conversation_Id HAVING COUNT(Conversation_Id) > 1";
        $idConversations = getDataByQuery($query);
        $existConversation = false;
        // check
        foreach($idConversations as $idConversation){
            $query = "SELECT * FROM participatants WHERE Conversation_Id = {$idConversation['Conversation_Id']} GROUP BY Conversation_Id HAVING COUNT(Conversation_Id) = 2";
            $amountRow = count(getDataByQuery($query));
            if($amountRow > 0){
                $existConversation = true;
                $idExistConversation = $idConversation['Conversation_Id'];
                break;
            }
        }
        if($existConversation){
            echo "{
                \"type\" : \"exist\",
                \"idConversation\" : \"{$idExistConversation}\"
            }";
        }
        else{
            $query = "INSERT INTO conversation(Title, Creator_Id, Create_at, Update_at, Delete_at) VALUES (NULL, {$_SESSION['idUser']}, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL)";
            excuteQuery($query);

            $query = "SELECT MAX(id) as max FROM conversation";
            $idConversation = getDataByQuery($query)[0]['max'];
            
            $query = "
                INSERT INTO participatants(Conversation_Id, Users_Id) VALUES ({$idConversation}, {$_SESSION['idUser']});
                INSERT INTO participatants(Conversation_Id, Users_Id) VALUES ({$idConversation}, {$idFriend});
            ";
            excuteMutilQuery($query);
            echo "{
                \"type\" : \"not exist\"
            }";
        }
    }
?>