<?php
    require './backend/web_config.php';
    load_top();
?>

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
            <form action="./chat.php" method="post">
                <input id="txtUsername" name="email" class="form-control" type="text" placeholder="Nhập tài khoản"><br>
                <input id="txtPassword" name="password" class="form-control" type="password" placeholder="Nhập mật khẩu"><br>
                <input  class="btnLogin btn btn-primary" type="submit" name="login" value="Đăng Nhập"><br>
            </form>
        </div>
        <a href="./register.php" class="reg-link nav-link">Chưa có tài khoản? Đăng ký ngay</a>
</div>

   
<?php load_footer(); ?>