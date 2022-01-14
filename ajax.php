<?php
    session_start();
    if(!isset($_SESSION['idUser'])){
        header('location: index.php');
    }
    else if(isset($_GET['sendRequest'])){
        require_once('./backend/mysql_config.php');
        
        $idUser = $_SESSION['idUser'];
        $otherId = $_GET['sendRequest'];
        $query = " INSERT INTO `relations` (`from`, `to` , `status`) VALUES
                    ($idUser, $otherId, 'P')";
        excuteQuery($query);
    }
    else if(isset($_GET['cancelRequest'])){
        require_once('./backend/mysql_config.php');
        
        $idUser = $_SESSION['idUser'];
        $otherId = $_GET['cancelRequest'];
        $query = " DELETE FROM `relations` WHERE `from` = $idUser AND `to` = $otherId";
        excuteQuery($query);
    }
    else if(isset($_GET['acceptRequest'])){
        require_once('./backend/mysql_config.php');
        
        $idUser = $_SESSION['idUser'];
        $otherId = $_GET['acceptRequest'];
        $query = " UPDATE `relations` SET `status` = 'F' WHERE `from` = $idUser AND `to` = $otherId";
        executeQuery($query);
    }
    else if(isset($_GET['cancelFriend'])){
        require_once('./backend/mysql_config.php');
        
        $idUser = $_SESSION['idUser'];
        $otherId = $_GET['cancelFriend'];
        $query = " DELETE FROM `relations` WHERE `from` = $idUser AND `to` = $otherId OR `from` = $otherId AND `to` = $idUser";
        excuteQuery($query);
    }
    else{
            require_once('./backend/mysql_config.php');
            $idUser = $_SESSION['idUser'];

          

            // Search Data Users
            $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
            $a = $_POST['data'];
            $sql = "SELECT * FROM users where (Email like '%$a%' OR FirstName like '%$a%' OR Phone like '%$a%') AND `id` != $idUser";
            $query = mysqli_query($connect, $sql);
            $num = mysqli_num_rows($query);
            
            
            // CHECK ALREADY FRIENDS 
            $check = "SELECT * FROM `relations` WHERE `status` = 'F'";
            $queryCheck = mysqli_query($connect, $check);
            $listFriend = mysqli_fetch_all($queryCheck, MYSQLI_ASSOC);
            
            function isPending($otherId){
                require_once('./backend/mysql_config.php');
                $listPending = "SELECT * FROM `relations` WHERE `status` = 'P'";
                $data = getDataByQuery($listPending);
                $idUser = $_SESSION['idUser'];
                foreach($data as $pending){
                    if($pending['from'] == $idUser && $pending['to'] == $otherId){
                        return true;
                    }
                }
                return false;
            }
            
            function receivePending($otherId){
                require_once('./backend/mysql_config.php');
                $listPending = "SELECT * FROM `relations` WHERE `status` = 'P'";
                $data = getDataByQuery($listPending);
                $idUser = $_SESSION['idUser'];
                foreach($data as $pending){
                    if($pending['from'] == $otherId && $pending['to'] == $idUser){
                        return true;
                    }
                }
                return false;
            }
            
            function isFriend($otherId){
                global $listFriend;
                $idUser = $_SESSION['idUser'];
                foreach($listFriend as $friend){
                    if($friend['from'] == $idUser && $friend['to'] == $otherId){
                        return true;
                    }
                    if($friend['from'] == $otherId && $friend['to'] == $idUser){
                        return true;
                    }
                }
                return false;
            }
           

            // Output Data
            if($num > 0){
                while($row = mysqli_fetch_array($query)){  
                    if($row['Gender'] == 1)
                        $row['Gender'] = "Nam";
                    else{
                        $row['Gender'] = "Nữ";
                    } 
                $nameUser = $row['FirstName']." ".$row['LastName'];
                $url = 'backend/avatar/' . $row['id'];
                if(file_exists($url . '.jpg')){
                    $url .= '.jpg';
                }   
                else if(file_exists($url . '.png')){
                    $url .= '.png';
                }
                else if(file_exists($url . '.jpeg')){
                    $url .= '.jpeg';
                }
                else{
                    $url = 'frontend/img/avatar-default-icon.png';
                }   
                if(isFriend($row['id'])){
                    $view =  "
                        <div class='information-card'>
                            <img class='user-avt' src='$url' alt=''>
                            <div class='information-card__content'>
                                <a class='link-information' href='#'>{$nameUser}</a>
                                <p class='phone'>{$row['Phone']}</p>
                            </div>
                            <button id='{$row['id']}' class='friend-options cancel-friend' type='submit'><span class='material-icons'>person_add</span>Hủy kết bạn</button>
                        </div>";
                }  
                elseif(isPending($row['id'])){
                    $view =  "
                        <div class='information-card'>
                            <img class='user-avt' src='$url' alt=''>
                            <div class='information-card__content'>
                                <a class='link-information' href='#'>{$nameUser}</a>
                                <p class='phone'>{$row['Phone']}</p>
                            </div>
                            <button id='{$row['id']}' class='friend-options cancel-request' type='submit'><span class='material-icons'>person_add</span>Hủy lời mời</button>
                        </div>";
                }
                elseif(receivePending($row['id'])){
                    $view =  "
                        <div class='information-card'>
                            <img class='user-avt' src='$url' alt=''>
                            <div class='information-card__content'>
                                <a class='link-information' href='#'>{$nameUser}</a>
                                <p class='phone'>{$row['Phone']}</p>
                            </div>
                            <button id='{$row['id']}' class='friend-options accept-request' type='submit'><span class='material-icons'>person_add</span>Chấp nhận</button>
                        </div>";
                }
                else{
                    $view =  "
                        <div class='information-card'>
                            <img class='user-avt' src='$url' alt=''>
                            <div class='information-card__content'>
                                <a class='link-information' href='#'>{$nameUser}</a>
                                <p class='phone'>{$row['Phone']}</p>
                            </div>
                            <button id='{$row['id']}' class='friend-options request' type='submit'><span class='material-icons'>person_add</span>Kết bạn</button>
                        </div>";
                }
                echo $view;
        }
    }
}
?>