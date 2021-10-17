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
                    <input class="textbox" type="text" value="1/1/2000">
                    <p class="birthday__calendar"><i class="far fa-calendar"></i></p> 
                    <div class="date-picker" style="display: none;">
                        <div class="date-picker__choice">
                            <p class="left-arrow">
                                <i class="fas fa-chevron-left"></i>
                            </p>
                            <div class="month-year">
                                <p>Tháng <span>1</span></p>,
                                <p style="margin-left: 5px;">2000</p>
                            </div>
                            <p class="right-arrow">
                                <i class="fas fa-chevron-left" style="transform: rotateZ(180deg);"></i>
                            </p>
                        </div>
                        <div class="date-picker__main">
                            <div class="days">
                                <p>Sun</p>
                                <p>Mon</p>
                                <p>Tue</p>
                                <p>Wed</p>
                                <p>Thu</p>
                                <p>Fri</p>
                                <p>Sat</p>
                            </div>
                            <div class="dates">                               
                            </div>
                            <div class="months">                              
                            </div>
                            <div class="years">                               
                            </div>
                        </div>
                    </div>                      
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
    <script src="./frontend/registerScript.js"></script>   
</div>
<?php load_footer(); ?>