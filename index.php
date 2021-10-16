<?php
    require './backend/web_config.php';
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
            <form method="$_POST" action="./chat.php">
                <input id="txtUser" class="form-control" type="text" placeholder="Nhập email hoặc số điện thoại"><br>
                <input id="txtPass" class="form-control" type="password" placeholder="Nhập mật khẩu"><br>
                <input class="btnLogin btn btn-primary" type="button" name="login" value="Đăng Nhập"><br>
            </form>
        </div>
            <a href="./register.php" class="reg-link nav-link">Chưa có tài khoản? Đăng ký ngay</a>

     
            <img class="preview" src="./frontend/img/background.jpeg" alt="Preview">
</div>




<?php load_footer(); ?>