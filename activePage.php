<?php session_start(); ?>
<?php
    if(!isset($_SESSION['idUser'])){
        header('location: index.php');
    }
    else{
        require_once('backend/mysql_config.php');
        $data = getDataByQuery("SELECT Count(*) as amount FROM userActive WHERE id = {$_SESSION['idUser']}");
        if($data[0]['amount'] == 0){
            header('location: index.php');
        }
    }
    $countDown = -1;
    function checkSecondSendMail($haveSendMail = false){
        global $countDown;
        if(file_exists('countDown.txt')){
            $data = json_decode(file_get_contents('countDown.txt'));
            $time = time();
            if($time - $data->currentSecond <= 30){
                $countDown = 30 - ($time - $data->currentSecond);
            }
            else{
                $countDown = -1;
                unlink('countDown.txt');
                if($haveSendMail){
                    echo 'send mail<br/>';
                    sendMailToUser();
                }
            }
        }
    }
    function sendMailToUser($activeCode = ''){
        require_once('backend/mysql_config.php');
        $idUser = $_SESSION['idUser'];
        $data = getDataByQuery("SELECT email FROM users WHERE id = {$idUser}");    
        $email = $data[0]['email'];
        if($activeCode == ''){
            $data = getDataByQuery("SELECT ActiveCode FROM userActive WHERE id = {$_SESSION['idUser']}");
            $activeCode = $data[0]['ActiveCode'];
        }

        require_once('backend/mail_config/mail_config.php');
        sendMail($email, "Mã kính hoạt của bạn là: {$activeCode}");   
    }
    checkSecondSendMail(); // load page
    if(isset($_POST['sendAgain'])){  
        if(!file_exists('countDown.txt')){
            $countDown = 30;
            $data = ['currentSecond' => time()];
            file_put_contents('countDown.txt',json_encode($data));
            sendMailToUser();
        }
        else{
            checkSecondSendMail(true);
        }   
    }
    if(isset($_POST['sendMail'])){
        if(isset($_SESSION['activeCode'])){
            sendMailToUser($_SESSION['activeCode']);
            unset($_SESSION['activeCode']);           
        }
    }
    $validations = [];
    if(isset($_POST['confirm'])){
        if($_POST['activeCode'] == ''){
            $validations['activeCodeIsEmpty'] = true;
        }
        else{
            $data = getDataByQuery("SELECT ActiveCode FROM userActive WHERE id = {$_SESSION['idUser']}");
            $activeCode = $data[0]['ActiveCode'];

            if($_POST['activeCode'] != $activeCode){
                $validations['activeCodeIsInValid'] = true;
            }
            else{
                $validations['activeCodeIsValid'] = true;

                require_once('backend/mysql_config.php');
                $query = "DELETE FROM useractive WHERE id = {$_SESSION['idUser']}";
                excuteQuery($query);
            }
        }      
    }      
?>

<?php
    require_once('backend/web_config.php');
    load_top();
?>
<div class="main">
    <link rel="stylesheet" type="text/css" href="frontend/activePageStyle.css">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off">
        <p class="title">Nhập mã kính hoạt để tiếp tục...</p>
        <div class="active">
            <input type="text" class="textbox" name="activeCode" value="<?php 
                if(isset($_POST['activeCode'])){
                    echo $_POST['activeCode'];
                }
            ?>">
            <input type="submit" name="confirm" value="Xác nhận">
            <input type="submit" name="sendAgain" value="Gửi lại mã" class="send-again">
            <p class="wait" style="display: none;">Chờ trong <span>20</span>s...</p>
        </div>        
        <?php 
            if(isset($validations['activeCodeIsEmpty'])){
                echo '<p class="error">Hãy nhập mã kích hoạt!<p>';
            }
            else if(isset($validations['activeCodeIsInValid'])){
                echo '<p class="error">Mã kích hoạt không đúng!<p>';
            }
            else if(isset($validations['activeCodeIsValid'])){
                echo "<script> alert('Kích hoạt thành công'); 
                    document.location = './';
                </script>";
            }
        ?>
    </form>
    <?php
        $script = "<script>
            var countDown = $countDown;
        </script>";
        echo $script;
    ?>
    <script src="frontend/activePageScript.js"></script>
</div>
<?php load_footer();?>