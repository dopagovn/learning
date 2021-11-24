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
                        $contentMessage .= "
                            <div class='area-message__message' style='justify-content: flex-end; margin-right: 10px;'>
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
                        $contentMessage .= "
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
                $view[] = $contentMessage;
            }
            $json = json_encode($view);
            echo $json;
        }       
    }
    else if(isset($_POST['ChooseConversation'])){
        $_SESSION['ConversationChosen'] = $_POST['ChooseConversation'];
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