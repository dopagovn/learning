<?php
    session_start();
    if(!isset($_SESSION['idUser'])){
        header('location: index.php');
    }
    else{
        require_once('./backend/mysql_config.php');
        $idUser = $_SESSION['idUser'];
        if(isset($_GET['search']) && isset($_GET['keyword'])){
            $keyword = $_GET['keyword'];
            $query = "SELECT * FROM relations JOIN users ON IF(`from` != {$idUser}, `from`, `to`) = users.id WHERE status = 'F' AND (`from` = {$idUser} OR `to` = {$idUser})";
            $listFriends = getDataByQuery($query);
            $listResult = [];
            foreach($listFriends as $friend){
                $nameFriend = $friend['LastName'] . ' ' . $friend['FirstName'];
                if(stripos($nameFriend, $keyword) !== false){
                    $friend['avatar'] = getAvatarById($friend['id']);
                    $listResult[] = $friend;
                }
            }
            echo json_encode($listResult);
        }
    }
?>