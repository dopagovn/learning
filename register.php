<?php 
    require('./backend/web_config.php');
    load_top();
?>
<div class="container">
    <link rel="stylesheet" type="text/css" href="./frontend/registerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <p id="login-title"><b>Đăng ký</b></p>
    <form class="register" method="POST">
        <div class="register__row">
            <div>
                <p class="title">Họ</p>
                <input class="textbox" type="text">
            </div>
            <div>
                <p class="title">Tên</p>
                <input class="textbox" type="text">
            </div>
        </div>
        <div class="register__row">
            <div>
                <p class="title">Ngày sinh</p>
                <div class="birthday">
                    <input class="textbox" type="text" value="1/1/1900">
                    <p class="birthday__calendar"><i class="far fa-calendar"></i></p>                       
                </div>
                <div class="date-picker">

                </div>
            </div>
            <div>
                <p class="title">Giới tính</p>
                <div class="gender">
                    <p>
                        <input type="radio" name="gender" value="male" checked> <span>Nam</span>
                    </p>
                    <p>
                        <input type="radio" name="gender" value="female"> <span>Nữ</span>
                    </p>                    
                </div>
            </div>
        </div>
        <div class="register__row register__row--1">
            <div>
                <p class="title">Email</p>
                <input class="textbox" type="text">
            </div>
        </div>
        <div class="register__row register__row--1">
            <div>
                <p class="title">Mật khẩu</p>
                <input class="textbox" type="password">
            </div>
        </div>
        <div class="register__row register__row--1">
            <div>
                <p class="title">Nhập lại mật khẩu</p>
                <input class="textbox" type="password">
            </div>
        </div>
        <div class="register__row register__row--1">
            <div>
                <p class="title">Số điện thoại</p>
                <input class="textbox" type="text">
            </div>
        </div>
        <div class="register__row register__row--1">
            <div>
                <input class="cb-policy" type="checkbox" name="agreenPolicy"><span> Tôi đồng ý với <a>điều khoản</a> & <a>chính sách</a></span>
            </div>
        </div>
        <div class="register__row register__row--1">
            <div>
                <button type="submit" class="agree">Đăng ký</button>
            </div>
        </div>
    </form>   
</div>
<?php load_footer(); ?>