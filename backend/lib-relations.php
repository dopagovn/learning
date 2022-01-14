<?php 
    session_start();
    if(!isset($_SESSION['idUser'])){
        header('location: index.php');
    }else{
        require_once('./mysql_config.php');
        $idUser = $_SESSION['idUser'];
        
            
        $query = "SELECT * FROM `relations` WHERE `status` = 'F'";
        $data = getDataByQuery($query);
        
        
    }
    
?>