<?php
    session_start();
    if(isset($_SESSION['idUser'])){
        header('location: chat.php');
    }else {
            if(isset($_POST['login'])){
            //Validation Form
                $validation = [];
                if(empty($_POST['email'])){
                    $validation['EmailIsEmpty'] = true;
                }

                require_once './backend/mysql_config.php';
                $email = $_POST['email'];
                $password  = md5($_POST['password']);

            
                $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);

                $sql = "SELECT * FROM users WHERE Email = '$email' AND Password = '$password'";
                $result = mysqli_query($connect, $sql);
                $row = mysqli_fetch_array($result);

                // print_r($row);

                if($row){

                    $_SESSION['idUser'] = $row[0];

                    header("location: chat.php");
                }else{
                    header("location:index.php");
                }
        }
    }

?>

<?php 
    require_once './backend/web_config.php';
    load_top();
    ch_title("Chat cùng chúng tôi");
?>
<!-- Index CSS -->
<link href="./frontend/index.css" rel="stylesheet"> 

<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
            <div class=" justify-content-start">
                <a href="#" class="navbar-brand mb-0 h1">LOGO</a>
            </div>
</nav>
<h2 class="about">Kết nối<br>với mọi người. <br /> Thêm bạn thêm vui</h2>



<form class="area-form__login" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off">
    <div class="login-form">
        
        <input id="Email" name="email" class="textBoxLogin" type="text" placeholder="Nhập Email">
        <?php 
            if(isset($validation['EmailIsEmpty'])){
                echo '<span>Vui long nhap Email</span>';
            }
        ?>
        <input id="Password" name="password" class="textBoxLogin" type="password" placeholder="Nhập mật khẩu">   
    </div>
    <button class="btnLogin" type="submit" name="login">Đăng nhập</button> <br />
    <a class="reg-link" href="./register.php">Chưa có tài khoản? Đăng ký ngay</a>
</form>

<?php load_footer(); ?>