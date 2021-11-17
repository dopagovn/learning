<?php 
    session_start();
    if(!isset($_SESSION['idUser'])){
        header('location: index.php');
    }
    else if(isset($_POST['CheckConversation'])){
        if(isset($_SESSION['idConversations'])){
            require_once('backend/mysql_config.php');

            $idUser = $_SESSION['idUser'];
            $idConversations = $_SESSION['idConversations'];
            $messages = [];
            foreach($idConversations as $idConversation){
                $query = "SELECT * FROM messages WHERE Conversation_Id = {$idConversation['Conversation_Id']}";
                $messages[] = getDataByQuery($query);    
            }
            $view = [];
            foreach($messages as $message){
                $contentMesage = "";
                foreach($message as $mes){
                    $time = $mes['Create_at'];
                    $time = explode(' ', $time);
                    $time = explode(':' ,$time[1]);
                    $time = $time[0] . ':' . $time[1];
                    if($mes['Sender_Id'] == $idUser){
                        $contentMesage .= "
                            <div class='area-message__message' style='justify-content: flex-end; margin-right: 10px;'>
                                <img class='avatar' src='./frontend/img/user1.jpeg'>
                                <div class='content'>
                                    <p class='content__name'>Bạn</p>
                                    <p class='content__message'>{$mes['Message']}</p>
                                    <p class='content__time'>{$time}</p>
                                </div>
                            </div>
                        ";
                    }
                    else{
                        $namePaticipatant = getDataByQuery("SELECT LastName, FirstName FROM users WHERE id = {$mes['Sender_Id']}");
                        $namePaticipatant = $namePaticipatant[0]['LastName'] . ' ' . $namePaticipatant[0]['FirstName'];
                        $contentMesage .= "
                            <div class='area-message__message'>
                                <img class='avatar' src='./frontend/img/user1.jpeg'>
                                <div class='content'>
                                    <p class='content__name'>{$namePaticipatant}</p>
                                    <p class='content__message'>{$mes['Message']}</p>
                                    <p class='content__time'>{$time}</p>
                                </div>
                            </div>
                        ";
                    }
                }
                // $view .= "
                //     <div class='area-message'>
                //         <div class='area-message__timer'>
                //             <div class='side' style='margin-left: 65px;'></div>
                //             <div class='time'>8:18&nbsp23/10/2021</div>
                //             <div class='side' style='margin-right: 65px;'></div>
                //         </div>
                //     </div>
                // ";
                $view[] = $contentMesage;
            }
            $json = json_encode($view);
            echo $json;
        }       
    }
    else if(isset($_POST['ConversationChosen'])){
        $_SESSION['ConversationChosen'] = $_POST['ConversationChosen'];
    }
    else if(isset($_POST['sendMessage'])){
        require_once('backend/mysql_config.php');
        if(!empty($_POST['sendMessage']) && isset($_SESSION['ConversationChosen'])){
            $contentMessage = $_POST['sendMessage'];
            $currentIdConversation = $_SESSION['ConversationChosen'];
            $query = "INSERT INTO messages(Conversation_Id, Sender_Id, Message_Type, Message, Attachment_url, Create_at)
                VALUES ({$currentIdConversation}, {$_SESSION['idUser']}, 'text', N'{$contentMessage}', NULL, CURRENT_TIMESTAMP)
            ";
            excuteQuery($query);
        }
    }
?>