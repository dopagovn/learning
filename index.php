<?php session_start(); ?>

<?php
    if(isset($_POST['login'])){
        $check = [];
        if(empty($_POST['email'])){
            $check['emailIsEmpty'] = true;
        }
        if(empty($_POST['password'])){
            $check['passwordIsEmpty'] = true;
        }
        require_once './backend/mysql_config.php';
        $email = $_POST['email'];
        $password  = $_POST['password'];
    
        $password = md5($password);
    
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
    
        $sql = "SELECT * FROM users WHERE Email = '$email'";
        $result = $connect->query($sql)->fetch_assoc();
     
        if($result['Password'] == $password ){
            echo         "<script>
                            var check = alert('Đăng nhập thành công');
                            document.location = './chat.php';
                        </script>";
        }else{
                
        }
    }

?>

<?php 
    require_once './backend/web_config.php';
    load_top();
?>
<!-- Index CSS -->
<link href="./frontend/index.css" rel="stylesheet"> 


<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid justify-content-start">
                <a href="#" class="navbar-brand mb-0 h1">LOGO</a>
            </div> 
           
            <form class="log-re flex-d col-sm-2">
                   
            </form>
</nav>

<div class="container">
        <h2 id="about">Kết nối<br>với mọi người <br>thật dễ dàng</br></h2>
        <div class="login-form col-4">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <input id="txtUsername" name="email" class="form-control" type="text" placeholder="Nhập tài khoản"><br>
                <?php
                    if(isset($check['emailIsEmpty'])){
                        echo '<p class="error">Hãy nhập tài khoản</p>';  
                    }
                ?>
                <input id="txtPassword" name="password" class="form-control" type="password" placeholder="Nhập mật khẩu"><br>
                <?php
                    if(isset($check['passwordIsEmpty'])){
                        echo '<p class="error">Hãy nhập mật khẩu</p>';  
                    }
                ?>
                <input  class="btnLogin btn btn-primary" type="submit" name="login" value="Đăng Nhập"><br>
            </form>
        </div>
        <a href="./register.php" class="reg-link nav-link">Chưa có tài khoản? Đăng ký ngay</a>
</div>


<?php load_footer(); ?>