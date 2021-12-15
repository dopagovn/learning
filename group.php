<?php
    session_start();
    if(!isset($_SESSION['idUser'])){
        header('location: index.php');
    }
    else{
        // get list friend
        $idUser = $_SESSION['idUser'];
        require_once('backend/mysql_config.php');
        require_once('backend/tool_file.php');
        if(isset($_POST['getListFriend'])){
            $query = "SELECT * FROM relations WHERE (`from` = {$idUser} OR `to` = {$idUser}) AND status = 'F'";
            $listFriends = getDataByQuery($query);
            $view = '';
            foreach($listFriends as $friend){
                $idFriend;
                if($friend['to'] != $idUser){
                    $idFriend = $friend['to'];
                }
                else{
                    $idFriend = $friend['from'];
                }
                $avatarFriendUrl;
                $ext;
                if(testImageExist('backend/avatar/' . $idFriend, $ext)){
                    $avatarFriendUrl = 'backend/avatar/' . $idFriend . '.' . $ext;
                }
                else{
                    $avatarFriendUrl = 'frontend/img/avatar-default-icon.png';
                }
                $query = "SELECT LastName, FirstName FROM users WHERE id = {$idFriend}";
                $nameFriend = getDataByQuery($query);
                $nameFriend = $nameFriend[0]['LastName'] . ' ' . $nameFriend[0]['FirstName'];
                $view .= "
                    <div class='list-friend__row'>
                        <input type='checkbox' name='idFriend[]' value='{$idFriend}'>
                        <img class='avatar' src='{$avatarFriendUrl}'>
                        <span>{$nameFriend}</span>
                    </div>
                ";
            }
            echo $view;
        }
        if(isset($_POST['createGroup'])){
            // check
            if(!isset($_POST['idFriend']) || count($_POST['idFriend']) < 2){
                header('location: chat.php?errorCreateGroup=true');
                exit();
            }
            //
            $nameGroup;
            if($_POST['nameGroup'] != ''){
                $nameGroup = $_POST['nameGroup'];
            }
            else{
                $query = "SELECT LastName, FirstName FROM users WHERE Id = {$idUser}";
                $nameUser = getDataByQuery($query);
                $nameUser = $nameUser[0]['LastName'] . ' ' . $nameUser[0]['FirstName'];
                $nameGroup = 'Nhóm của ' . $nameUser;
            }

            $query = "INSERT INTO conversation(Title, Creator_Id, Create_at, Update_at, Delete_at)
            VALUES (N'{$nameGroup}', {$idUser}, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
            excuteQuery($query);

            $query = "SELECT Max(id) as maxId FROM conversation";
            $conversationId = getDataByQuery($query);
            $conversationId = $conversationId[0]['maxId'];
            
            $query = "INSERT INTO participatants(Conversation_Id, Users_Id) VALUES({$conversationId}, {$idUser})";
            excuteQuery($query);

            foreach($_POST['idFriend'] as $idFriend){
                $query = "INSERT INTO participatants(Conversation_Id, Users_Id) VALUES({$conversationId}, {$idFriend})";
                excuteQuery($query);
            }

            header('location: chat.php');
        }
    }
?>