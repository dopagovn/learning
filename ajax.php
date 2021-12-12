<?php
    require_once('./backend/mysql_config.php');

    $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
    $a = $_POST['data'];
    $sql = "SELECT * FROM users where Email like '%$a%' OR FirstName like '%$a%' OR Phone like '%$a%'";
    $query = mysqli_query($connect, $sql);
    $num = mysqli_num_rows($query);
    if($num > 0){
        while($row = mysqli_fetch_array($query)){  
            if($row['Gender'] == 1)
                                $row['Gender'] = "Nam";
                                else{
                                    $row['Gender'] = "Nữ";
                                } 
         $nameUser = $row['FirstName']." ".$row['LastName'];
            
?>

                                 <?php  
                                
                                 $view =  "<div class='information-card'>
                                        <img class='user-avt' src='./backend/avatar/6.jpg' alt=''>
                                        <div class='information-card__content'>
                                            <a class='link-information' href='#'>{$nameUser}</a>
                                            <p class='phone'>{$row['Phone']}</p>
                                        </div>
                                        <button class='friend-options' type='submit'><span class='material-icons'>person_add</span>Kết bạn</button>
                                        </div>";
                                      echo $view;  
                                    ?>

<?php 
        }
    }
?>