<?php
    require './backend/web_config.php';
    load_top();
    load_footer();
?>

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
                <input id="username" class="form-control" type="text" placeholder="Nhập tài khoản"><br>
                <input id="password" class="form-control" type="password" placeholder="Nhập mật khẩu"><br>
                <input type="submit" class="btnLogin btn btn-primary" value="Đăng nhập">
                <a href="./register.php" class="nav-link">Chưa có tài khoản? Đăng ký ngay</a>
            </form>

            
        </div>
        
</div>
   
